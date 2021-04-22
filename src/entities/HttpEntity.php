<?php

    namespace Ngbin\Framework\Entity;

    use Ngbin\Framework\Core\Entity;

    /**
     * An entity which describes a Http entity
     */
    class HttpEntity extends Entity
    {

        /**
         * The list of headers
         * @var Array
         */
        protected $headers;

        public function __construct()
        {
            $this->headers = [];
        }

        /**
         * Get all the headers
         * @return Array Array of Headers
         */
        public function getHeaders()
        {
            return $this->headers;
        }

        /**
         * Add a new header
         * @param Header $header the header to add
         * 
         * @return void
         */
        public function addHeader(Header $header)
        {
            $this->headers[$header->getName()] = $header;
        }

    }    

?>