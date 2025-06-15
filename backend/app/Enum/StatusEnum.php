<?php

namespace App\Enum;

enum StatusEnum
{
    const SOLICITADO = 'solicitado';
    const APROVADO = 'aprovado';
    const CANCELADO = 'cancelado';

    public static function getValues(): array
    {
        return [
            self::SOLICITADO,
            self::APROVADO,
            self::CANCELADO,
        ];
    }

    public static function isValid($value): bool
    {
        return in_array($value, self::getValues(), true);
    }
}
