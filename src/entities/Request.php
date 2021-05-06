<?php

    namespace Ngbin\Framework\Entity;

    /**
     * An entity which represents the request handled
     */
    class Request extends HttpEntity
    {

        /**
         * Contains the request method
         * @var String
         */
        public $method;
        /**
         * Contains the data which was in the request uri
         * @var Array
         */
        public $params;
        /**
         * Contains the POST and PUT request data
         * @var Array
         */
        public $body;
        /**
         * Contains the GET request data
         * @var Array
         */
        public $query;
        /**
         * Contains the uri of the request
         * @var String
         */
        public $uri;

        /**
         * @param String $uri
         * @param String $method
         * @param Array $params
         * @param Array $body
         * @param Array $query
         */
        public function __construct(String $uri, String $method, Array $params = [], Array $body = [], Array $query = [])
        {
            parent::__construct();
            $this->method = $method;
            $this->params = $params;
            $this->body = $body;
            $this->uri = $uri;
            $this->query = $query;

            $headers = getallheaders();
            foreach ($headers as $header => $value) {
                $this->addHeader(new Header($header, $value));
            }
        }

    }

?>