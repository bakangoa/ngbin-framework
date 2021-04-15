<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    /**
     * An entity which represent a function route
     */
    class Route extends Entity
    {
        /**
         * The class of the function
         * @var String
         */
        public $class;
        /**
         * The function pointed
         * @var mixed
         */
        public $method;
        /**
         * The request to transmit as function argument
         * @var Request
         */
        public $request;

        /**
         * @param String $class
         * @param mixed $method
         * @param Request $request
         */
        public function __construct(String $class, $method, Request $request)
        {
            $this->class = $class;
            $this->method = $method;
            $this->request = $request;
        }
    }

?>