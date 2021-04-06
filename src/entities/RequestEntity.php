<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class RequestEntity extends Entity
    {

        public $method;
        public $params;
        public $body;
        public $query;
        public $uri;

        public function __construct(String $uri, String $method, Array $params = [], Array $body = [], Array $query = [])
        {
            $this->method = $method;
            $this->params = $params;
            $this->body = $body;
            $this->uri = $uri;
            $this->query = $query;
        }

    }

?>