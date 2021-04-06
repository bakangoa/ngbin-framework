<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class RouteEntity extends Entity
    {
        public $class;
        public $method;
        public $request;

        public function __construct(String $class, $method, RequestEntity $request)
        {
            $this->class = $class;
            $this->method = $method;
            $this->request = $request;
        }
    }

?>