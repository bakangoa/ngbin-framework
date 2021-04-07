<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    /**
     * An entity which represent the content of the response
     */
    class ContentEntity extends Entity
    {
        /**
         * The data contains in the content
         * @var mixed
         */
        private $data;
        /**
         * The HTTP attached to the content
         * @var int
         */
        private $code;

        /**
         * @param mixed $content
         * @param int $code
         */
        public function __construct($content, int $code = -1)
        {
            $this->data = $content;
            $this->code = $code;
        }

        /**
         * Function to get the content data
         * @return mixed
         */
        public function getData()
        {
            return $this->data;
        }

        /**
         * Function to get the content HTTP code.
         * Return -1 if this code can be ignored
         * @return int
         */
        public function getCode() : int
        {
            return $this->code;
        }
    }

?>