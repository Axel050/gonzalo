<?php

namespace App\Livewire\Admin\Auxiliares\Motivos;

use App\Models\MotivoDevolucion;
use Livewire\Component;

class Modal extends Component
{
    public $title;

    public $id;

    public $bg;

    public $method;

    public $btnText;

    public $motivo;

    public $nombre;

    public $descripcion;

    protected function rules()
    {

        if ($this->method == 'update') {
            $rules['nombre'] = 'required|unique:motivo_devolucions,nombre,'.$this->motivo->id;
        } else {
            $rules['nombre'] = 'required|unique:motivo_devolucions,nombre';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'Ingrese nombre.',
            'nombre.unique' => 'Nombre existente.',
        ];
    }

    public function mount()
    {

        if ($this->method == 'save') {

            $this->title = 'Crear';
            $this->btnText = 'Guardar';
            $this->bg = 'background-color: rgb(22 163 74)';
        }

        if ($this->method == 'delete') {
            $this->motivo = MotivoDevolucion::find($this->id);
            $this->id = $this->motivo->id;
            $this->title = 'Eliminar';
            $this->btnText = 'Eliminar';
            $this->bg = 'background-color: rgb(239 68 68)';
        }
        if ($this->method == 'update' || $this->method == 'view') {
            $this->motivo = MotivoDevolucion::find($this->id);
            $this->nombre = $this->motivo->nombre;
            $this->descripcion = $this->motivo->descripcion;

            if ($this->method == 'update') {
                $this->title = 'Editar';
                $this->bg = 'background-color: rgb(234 88 12)';
                $this->btnText = 'Guardar';
            } else {
                $this->title = 'Ver';
                $this->bg = 'background-color: rgb(31, 83, 44)';
            }
        }
    }

    public function save()
    {

        $this->validate();

        MotivoDevolucion::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        $this->dispatch('motivoCreated');
    }

    public function update()
    {

        if (! $this->motivo) {
            $this->dispatch('motivoNotExits');
        } else {
            $this->validate();

            $this->motivo->nombre = $this->nombre;
            $this->motivo->descripcion = $this->descripcion;

            $this->motivo->save();
            $this->dispatch('motivoUpdated');
        }
    }

    public function delete()
    {
        if (! $this->motivo) {
            $this->dispatch('motivoNotExits');
        } else {

            if ($this->motivo->devoluciones()->exists()) {
                $this->addError('tieneDatos', 'motivo con devoluciones asociadas');

                return;
            }

            $this->motivo->delete();
            $this->dispatch('motivoDeleted');
        }
    }

    public function render()
    {
        return view('livewire.admin.auxiliares.motivos.modal');
    }
}
