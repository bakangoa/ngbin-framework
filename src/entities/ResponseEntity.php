<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    /**
     * An entity which represents the HTTP response
     */
    class ResponseEntity extends Entity
    {
        /**
         * Contains the response data
         * @var mixed
         */
        private $content;

        /**
         * @param ContentEntity $content
         */
        public function __construct(ContentEntity $content)
        {
            if ($content->getCode() != -1)
            {
                http_response_code($content->getCode());
            }
            $this->content = $content->getData();
        }

        /**
         * Send the response
         * @return void
         */
        public function end()
        {
            echo $this->content;
        }
    }

?>