<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    class ResponseEntity extends Entity
    {
        private $content;

        public function __construct(ContentEntity $content)
        {
            if ($content->getCode() != -1)
            {
                http_response_code($content->getCode());
            }
            $this->content = $content->getData();
        }

        public function end()
        {
            echo $this->content;
        }
    }

?>