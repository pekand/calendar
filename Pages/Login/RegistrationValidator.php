<?php

namespace Pages\Login;

use Core\Validator;

/*
    Registration form validator
*/
class RegistrationValidator extends Validator
{
    public function usernameNotExist($paramName,  $errorMessage = "Username already exists.") {
        $value = $this->getValue($paramName);

        $repository = $this->container->get('UserRepository');
        $user = $repository->getUserByUsername($value);

        if (!empty($user)) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    function check($group = "") {
            $this->isNotEmpty('username');
            $this->isEmail('username');
            $this->usernameNotExist('username');
            $this->isNotEmpty('password');
            $this->hasMinimalLength('password', 6);
            $this->isNotEmpty('password_confirmation');
            $this->isEqual('password', 'password_confirmation');
    }

}
