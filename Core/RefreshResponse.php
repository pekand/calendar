<?php

namespace Core;

class RefreshResponse extends Response{
    function out() {
        header("Refresh:0");
        die();
    }
}
