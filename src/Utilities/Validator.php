<?php
namespace Communication\Utilities;

use Communication\Exceptions\Validation;

class Validator
{
    public function validateEmail($email)
    {
        $cleanerEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($cleanerEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new Validation('email ' . $cleanerEmail . ' is invalid');
        }
    }

    /**
     * @param $object  Object or array of objects
     */
    public function validateRequiredObject($object)
    {
        $attributes = get_class_vars(get_class($object));

        foreach ($attributes as $key => $value) {
            $this->validateRequired($object, $key);
        }
    }

    private function validateRequired($object, $attribute)
    {
        if (empty($object->{$attribute}) === true) {
            throw new Validation('value ' . $attribute . ' must be set');
        }
    }
}
