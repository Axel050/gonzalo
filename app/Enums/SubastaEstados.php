<?php

namespace App\Enums;

class SubastaEstados
{
    public const ACTIVA = 'activa';

    public const INACTIVA = 'inactiva';

    public const ENPUJA = 'enpuja';

    public const FINALIZADA = 'finalizada';

    public const PAUSADA = 'pausada';

    public const PAUSADA_PROX = 'pausada_prox';

    /**
     * Obtener todos los estados como array.
     */
    public static function all(): array
    {
        return [
            self::ACTIVA,
            self::INACTIVA,
            self::ENPUJA,
            self::FINALIZADA,
            self::PAUSADA,
            self::PAUSADA_PROX,
        ];
    }

    /**
     * Obtener el nombre legible de un estado.
     */
    public static function getLabel(string $estado): string
    {
        return match ($estado) {
            self::ACTIVA => 'Activa',
            self::INACTIVA => 'Inactiva',
            self::ENPUJA => 'En Puja',
            self::FINALIZADA => 'Finalizada',
            self::PAUSADA => 'Pausada',
            self::PAUSADA_PROX => 'Pausada Prox',
            default => 'Desconocido',
        };
    }
}
