<?php

namespace App\Validator;

use RuntimeException;

class Validator
{
    /**
     * Validates an array of fields according to specific rules.
     *
     * @param array $fields The array of fields to validate.
     *
     * @return array The validated fields.
     *
     * @throws RuntimeException If a field fails validation.
     */
    public static function validate(array $fields): array
    {
        foreach ($fields as $field => $value) {
            if ($field === 'name') {
                $length = strlen($value);

                if ($length < 3) {
                    throw new RuntimeException("O campo ($field) precisa ter no mínimo 3 caracteres.");
                }

                if ($length > 100) {
                    throw new RuntimeException("O campo ($field) precisa no máximo 100 caracteres.");
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

    /**
     * Validates if a value is required.
     *
     * @param mixed $value The value to validate.
     *
     * @return bool True if the value is required, false otherwise.
     */
    protected static function validateRequired(mixed $value): bool
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

}
