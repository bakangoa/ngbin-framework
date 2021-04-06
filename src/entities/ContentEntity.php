<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class ContentEntity extends Entity
    {
        private $data;
        private $code;

        public function __construct(mixed $content, int $code = -1)
        {
            $this->data = $content;
            $this->code = $code;
        }

        public function getData() : mixed
        {
            return $this->data;
        }

        public function getCode() : int
        {
            return $this->code;
        }
    }

?>