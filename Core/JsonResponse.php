<?php

namespace Core;

class JsonResponse extends Response{
    function out() {
          header('Content-Type: application/json');
          echo json_encode($this->getBody());
    }
}
