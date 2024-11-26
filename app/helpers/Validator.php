<?php

namespace Helpers;

class Validator
{
    protected array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            foreach (explode('|', $ruleSet) as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        return empty($this->errors);
    }

    protected function applyRule(string $field, $value, string $rule): void
    {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = 'This field is required.';
        }

        if (str_starts_with($rule, 'max:')) {
            $max = (int)str_replace('max:', '', $rule);
            if (strlen($value) > $max) {
                $this->errors[$field][] = "This field must not exceed {$max} characters.";
            }
        }

        if (str_starts_with($rule, 'min:')) {
            $min = (int)str_replace('min:', '', $rule);
            if (strlen($value) < $min) {
                $this->errors[$field][] = "This field must be at least {$min} characters.";
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
