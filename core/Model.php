<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';

    public const RULE_EMAIL = 'email';

    public const RULE_MIN = 'min';

    public const RULE_MAX = 'max';

    public const RULE_MATCH = 'match';

    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    abstract public function rules(): array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }
    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'Email is not valid',
            self::RULE_MIN => 'Minimum length of {min} characters',
            self::RULE_MAX => 'Maximum length of {max} characters',
            self::RULE_MATCH => 'This field must match {match}',
        ];
    }

    public function attributes()
    {
        return [];
    }

    public function labels()
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
