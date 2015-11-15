<?php

namespace Pages\Login;

use Core\ServiceContainer;

class LoginServices extends ServiceContainer {

    private $loginValidator = null;
    private $registrationValidator = null;

    private $userManager = null;
    private $userRepository = null;

    public function getUserManagerService() {
        if (empty($this->userManager)) {
            $this->userManager = new \Pages\Login\UserManager();
            $this->userManager->setContainer($this->container);
        }

        return $this->userManager;
    }

    public function getUserRepositoryService() {
        if (empty($this->userRepository)) {
            $this->userRepository =  new \Pages\Login\UserRepository();
            $this->userRepository->setContainer($this->container);
        }

        return $this->userRepository;
    }

    public function getLoginValidatorService() {
        if (empty($this->loginValidator)) {
            $this->loginValidator =  new \Pages\Login\LoginValidator();
            $this->loginValidator->setContainer($this->container);
        }

        return $this->loginValidator;
    }

    public function getRegistrationValidatorService() {
        if (empty($this->registrationValidator)) {
            $this->registrationValidator =  new \Pages\Login\RegistrationValidator();
            $this->registrationValidator->setContainer($this->container);
        }

        return $this->registrationValidator;
    }
}
