<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Formatter\Formatter;

    /**
     * An entity which represents the HTTP response
     */
    class Response extends HttpEntity
    {
        /**
         * Contains the response data
         * @var mixed
         */
        private $content;

        /**
         * The HTTP attached to the content
         * @var int
         */
        private $code;

        /**
         * @param mixed $content
         * @param int $code 
         */
        public function __construct($content, Formatter $formatter = null, int $code = 200)
        {
            parent::__construct();
            $this->content = $content;
            $this->code = $code;
            if (!empty($formatter))
            {
                $this->content = $formatter->format($this->content);
            }
            http_response_code($this->code);
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

        /**
         * Return the response content
         * @return mixed
         */
        public function getContent()
        {
            return $this->content;
        }

        /**
         * Add an header to the response
         * @param String $name The name of the header
         * @param mixed $value The value of the header
         * 
         * @return void
         */
        public function setHeader(String $name, $value)
        {
            $this->addHeader(new Header($name, $value));
        }
    }

?>