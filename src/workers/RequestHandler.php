<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Core\HttpMethod;
    use Ngbin\Framework\Entity\Request;

    /**
     * A worker which handles the request context and extract required information for all other workers.
     * IMPORTANT : This is the first worker of the pipeline.
     */
    class RequestHandler extends \Ngbin\Framework\Core\Worker
    {
        const _URI = "REQUEST_URI";
        const _METHOD = "REQUEST_METHOD";

        /**
         * Function which create an Request from an HTTP request
         * @param mixed $data The HTTP request headers
         * 
         * @return Request
         */
        private function handle($data) : Request
        {
            $request = new Request($data[self::_URI], $data[self::_METHOD]);

            switch ($data[self::_METHOD]) {
                case HttpMethod::$get:
                    $request->query = $_GET;
                    break;

                case HttpMethod::$post:
                    $request->body = $_POST;
                    break;

                case HttpMethod::$put:
                    parse_str(file_get_contents("php://input"), $request->body);
                    break;

                case HttpMethod::$delete:
                    parse_str(file_get_contents("php://input"), $request->body);
                    break;
                
                default:
                    # code...
                    break;
            }

            return $request;
        }

        protected function process(Entity $data) : Request
        {
            return $this->handle($_SERVER);
        }
    }

?>