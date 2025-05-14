<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $firstName = '';
    public string $secondName = '';
    public string $email = '';
    public string $password = '';
    public string $passwordRepeat = '';

    public function register()
    {
        echo 'Registering user...';
    }

    public function rules(): array {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'secondName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'passwordRepeat' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
}
