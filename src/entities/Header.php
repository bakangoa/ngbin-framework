<?php

    namespace Ngbin\Framework\Entity;

    /**
     * A class which represents an HTTP request or response header
     */
    class Header
    {
        /**
         * The name of the header
         * @var String
         */
        private $name;
        /**
         * The value of the header
         * @var String
         */
        private $value;

        public function __construct($name, $value)
        {
            $this->name = $name;
            $this->value = $value;
        }

        /**
         * Function which return the value of the header's name
         * @return String
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Function which return the value of the header
         * @return String 
         */
        public function getValue()
        {
            return $this->value;
        }
    }

?>