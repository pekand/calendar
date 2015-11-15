<?php

namespace Core;

class RedirectResponse extends Response{
    function out() {
        header("Location: ".$this->getBody());
        die();
    }
}
