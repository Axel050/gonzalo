<?php

namespace App\Livewire\Admin\Contratos;

use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Subasta;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    //  ['method' => $method, 'id' => $id])
    public $test;

    public $title;

    public $id;

    public $bg;

    public $method;

    public $btnText;

    public $contrato;

    public $contrato_id;

    public $nombre;

    public $descripcion;

    public $lotes = true;

    public $comitente_id;

    public $subastas = [];

    public $comitentes = [];

    public $adquirente_id;

    public $subasta_id;

    public $monto;

    public $fecha_firma;

    public $estado;

    protected function rules()
    {
        $rules = [
            'comitente_id' => [
                'required',
                Rule::unique('contratos')->where(function ($query) {
                    return $query->where('comitente_id', $this->comitente_id)
                        ->where('subasta_id', $this->subasta_id)
                        ->whereNotNull('subasta_id')
                        ->whereNull('deleted_at');
                })->ignore(
                    $this->contrato->id ?? 0
                ),
            ],
            'fecha_firma' => 'required|date',
            // 'subasta_id' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'comitente_id.required' => 'Elija comitente.',
            'comitente_id.unique' => 'Comitente y subasta existente. ',
            'fecha_firma.required' => 'Elija fecha.',
            'subasta_id.required' => 'Elija subasta.',
        ];
    }

    public function mount()
    {

        $this->subastas = Subasta::orderBy('id', 'desc')->get();
        $this->comitentes = Comitente::with('alias')->orderBy('nombre')->get();

        if ($this->method == 'save') {

            $this->title = 'Crear';
            $this->btnText = 'Guardar';
            $this->bg = 'background-color: rgb(22 163 74)';
            $this->fecha_firma = date('Y-m-d');
        }

        if ($this->method == 'delete') {
            $this->contrato = Contrato::find($this->id);
            $this->id = $this->contrato->id;
            $this->title = 'Eliminar';
            $this->btnText = 'Eliminar';
            $this->bg = 'background-color: rgb(239 68 68)';
        }
        if ($this->method == 'update' || $this->method == 'view') {
            $this->contrato = Contrato::find($this->id);
            $this->comitente_id = $this->contrato->comitente_id;
            $this->subasta_id = $this->contrato->subasta_id;
            $this->fecha_firma = $this->contrato->fecha_firma;
            $this->descripcion = $this->contrato->descripcion;

            if ($this->method == 'update') {
                $this->title = 'Editar';
                $this->bg = 'background-color: rgb(234 88 12)';
                $this->btnText = 'Guardar';
            } else {
                $this->title = 'Ver';
                $this->bg = 'background-color: rgb(31, 83, 44)';
            }
        }

        $this->dispatch('modalOpenedContratos', comitenteId: $this->comitente_id);
    }

    #[On('setComitente')]
    public function setComitenteId($id)
    {
        $this->comitente_id = $id;
    }

    public function save()
    {

        // dd($this->subasta_id ?: null);
        $this->validate();
        $contrato = Contrato::create([
            'comitente_id' => $this->comitente_id,
            'descripcion' => $this->descripcion,
            'subasta_id' => $this->subasta_id ?: null,
            'fecha_firma' => $this->fecha_firma,
        ]);

        if ($this->lotes && $contrato) {
            // return $this->dispatch("lotes", $contrato->id);
            return $this->dispatch('lotes', $contrato->id, true);
        }

        $this->dispatch('contratoCreated');
    }

    // VER QUE CUANDO BORRO UN CONTATO SE PIERDE EL ULTIMO CONTRATO ; CAMPO DE LOTES
    public function update()
    {

        if (! $this->contrato) {
            $this->dispatch('contratoNotExits');
        } else {
            $this->validate();

            $prevSubastaId = $this->contrato->subasta_id;

            if ($prevSubastaId && ! $this->subasta_id) {
                $this->addError(
                    'subasta_id',
                    'No se puede dejar sin subasta, ya esta asignado a una subasta.'
                );

                return;
            }

            $subasta = null;
            if ($this->subasta_id) {
                $subasta = Subasta::find($this->subasta_id);
                if (! $subasta) {
                    $this->addError('subasta_id', 'Subasta inexistente.');

                    return;
                }
                if (
                    $subasta->estado === SubastaEstados::FINALIZADA
                    && (int) $prevSubastaId !== (int) $this->subasta_id
                ) {
                    $this->addError('subasta_id', 'No se puede elegir una subasta finalizada.');

                    return;
                }
            }

            $bloqueo = $this->contrato->puedeCambiarSubasta();

            if ($bloqueo) {
                $this->addError(
                    'subasta_id',
                    "No se puede cambiar la subasta: hay lotes con $bloqueo."
                );

                return;
            }

            $this->contrato->subasta_id = $this->subasta_id ?: null;

            $this->contrato->descripcion = $this->descripcion;
            $this->contrato->comitente_id = $this->comitente_id;
            $this->contrato->fecha_firma = $this->fecha_firma;

            $this->contrato->save();

            if (! $prevSubastaId && $this->subasta_id && $subasta) {
                $estado = in_array(
                    $subasta->estado,
                    [SubastaEstados::ACTIVA, SubastaEstados::ENPUJA],
                    true
                ) ? LotesEstados::EN_SUBASTA : LotesEstados::ASIGNADO;

                Lote::where('ultimo_contrato', $this->contrato->id)
                    ->where('estado', LotesEstados::DISPONIBLE)
                    ->update(['estado' => $estado]);
            }

            $this->dispatch('contratoUpdated');
        }
    }

    public function delete()
    {
        if (! $this->contrato) {
            $this->dispatch('contratoNotExits');
        } else {

            if ($this->contrato->contratoLotes()->exists()) {
                $this->addError(
                    'tieneDatos',
                    'Contrato con lotes asociados.'
                );

                return;
            }

            $this->contrato->delete();
            $this->dispatch('contratoDeleted');
        }
    }

    public function render()
    {
        return view('livewire.admin.contratos.modal');
    }
}
