<?php

namespace App\Validator;

use RuntimeException;

class Validator
{
    public static function validate(array $fields): array
    {
        foreach ($fields as $field => $value) {
            if ($field === 'name') {
                if (!self::validateMin($value, 3) || !self::validateMax($value, 100)) {
                    throw new RuntimeException("O campo ($field) precisa ter entre 3 e 100 caracteres.");
                }
            }

            if ($field === 'price') {
                if (!is_numeric($value)) {
                    throw new RuntimeException("O campo ($field) precisa ter um valor numerico");
                }

                if (((int) $value) <= 0) {
                    throw new RuntimeException("O campo ($field) precisa ser um número maior que zero.");
                }
            }

            if (!self::validateRequired($value)) {
                throw new RuntimeException("O campo ($field) é obrigatório.");
            }
        }

        return $fields;
    }

    protected static function validateRequired($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (is_string($value) && trim($value) === '') {
            return false;
        }

        if (is_countable($value) && count($value) < 1) {
            return false;
        }

        return true;
    }

    protected static function validateMax($value, $parameter): bool
    {
        if (is_countable($value)) {
            return count($value) <= $parameter;
        }

        return strlen($value) <= $parameter;
    }

    protected static function validateMin($value, $parameter): bool
    {
        if (is_countable($value)) {
            return count($value) >= $parameter;
        }

        return strlen($value) >= $parameter;
    }
}
