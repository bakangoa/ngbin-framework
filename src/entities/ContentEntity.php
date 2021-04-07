<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class ContentEntity extends Entity
    {
        private $data;
        private $code;

        public function __construct( $content, int $code = -1)
        {
            $this->data = $content;
            $this->code = $code;
        }

        public function getData()
        {
            return $this->data;
        }

        public function getCode() : int
        {
            return $this->code;
        }
    }

?>