<?php

namespace Core;

abstract class Validator extends ContainerAware {

    private $params = array();
    private $errors = array();
    protected $valid = false;

    function setParams($params) {
        $this->params= $params;
    }

    function getParams() {
        return $this->params;
    }

    function isValid() {
        return $this->valid;
    }

    function getValue($paramName) {
        if (isset($this->params[$paramName])) {
            return $this->params[$paramName];
        }

        return null;
    }

    function getErrors() {
        return $this->errors;
    }

    function addError($paramName, $errorMessage) {
        if (!isset($this->errors[$paramName])) {
            $this->errors[$paramName] = array();
        }

        $this->errors[$paramName][] = $errorMessage;
    }

    function hasError($paramName) {
        return isset($this->errors[$paramName]) && !empty($this->errors[$paramName]);
    }

    function getError($paramName) {
        if (isset($this->errors[$paramName])) {
            return $this->errors[$paramName];
        }

        return null;
    }

    function getErrorPlain($paramName) {
        if ($this->hasError($paramName)) {
            return implode(" ", $this->getError($paramName));
        }

        return "";
    }

    function validate($group = "") {
        $this->errors = array();
        $this->valid = false;

        $this->check($group);
        if (empty($this->errors)) {
            $this->valid = true;
        }

        return $this->valid;
    }

    public function isNotEmpty($paramName, $errorMessage = "Value can not be empty.") {
        $value = $this->getValue($paramName);

        if (empty($value)) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        if (is_string($value) && strlen(trim($value)) == 0) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isEqual($paramName1, $paramName2,  $errorMessage = "Value must be equal.") {
        $value1 = $this->getValue($paramName1);
        $value2 = $this->getValue($paramName2);

        if ($value1 != $value2) {
            $this->addError($paramName1, $errorMessage);
            $this->addError($paramName2, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isEmail($paramName,  $errorMessage = "Value must be email.") {
        $value = $this->getValue($paramName);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isDateTime($paramName,  $errorMessage = "Is not valid date and time.") {
        $value = $this->getValue($paramName);

        if (\DateTime::createFromFormat('Y-m-d H:i:s', $value) === false) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isInteger($paramName,  $errorMessage = "Is not valid integer.") {
        $value = $this->getValue($paramName);

        if (!is_numeric($value)) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isInInterval($paramName, $start, $end,  $errorMessage = "Is not in interval.") {
        $value = $this->getValue($paramName);

        if (!is_numeric($value) || $value<$start || $end<$value) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function isBool($paramName,  $errorMessage = "Is not valid bool.") {
        $value = $this->getValue($paramName);

        if (!is_numeric($value)) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    public function hasMinimalLength($paramName,  $minLength, $errorMessage = "The minimal length is ") {
        $value = $this->getValue($paramName);

        if (is_string($value) && strlen($value) < $minLength) {
            $this->addError($paramName, $errorMessage." ".$minLength.".");
            $this->valid = false;
            return false;
        }

        return true;
    }

    abstract function check($group = "");
}
