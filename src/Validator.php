<?php

namespace App;

use Valitron\Validator as ValitronValidator;

class Validator extends ValitronValidator {

    protected static $_lang = 'fr';

    /**
     * @param  string $field
     * @param  string $message
     * @param  array  $params
     * @return array
     */
    protected function checkAndSetLabel($field, $message, $params)
    {
        return str_replace('{field}', '', $message);
    }

}
