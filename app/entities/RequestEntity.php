<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class RequestEntity extends Entity
    {

        public $method;
        public $params;
        public $body;
        public $uri;

        public function __construct(String $uri, String $method, Array $params = [], Array $body = [])
        {
            $this->method = $method;
            $this->params = $params;
            $this->body = $body;
            $this->uri = $uri;
        }

    }

?>