<?php

namespace Pages\Login;

use Core\Validator;

/*
    Login form validator
*/
class LoginValidator extends Validator
{
    public function validCredentials($errorMessage = "Wrong credentials.") {
        $username = $this->getValue('username');
        $password = $this->getValue('password');

        $success = $this->container->get('Security')->checkCredentials($username, $password);

        if (!$success) {
            $this->addError('username', $errorMessage);
            $this->addError('password', $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    function check($group = "") {
            $this->isNotEmpty('username');
            $this->isEmail('username');
            $this->isNotEmpty('password');
            $this->hasMinimalLength('password', 6);

            if ($this->isValid()) {
                $this->validCredentials();
            }
    }

}
