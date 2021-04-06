<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\RequestEntity;

    class RequestHandler extends \Ngbin\Framework\Core\Worker
    {

        const _GET = "GET";
        const _POST = "POST";
        const _PUT = "PUT";
        const _DELETE = "DELETE";

        const _URI = "REQUEST_URI";
        const _METHOD = "REQUEST_METHOD";

        private function handle($data) : RequestEntity
        {
            $request = new RequestEntity($data[self::_URI], $data[self::_METHOD]);

            switch ($data[self::_METHOD]) {
                case self::_GET:
                    $request->query = $_GET;
                    break;

                case self::_POST:
                    $request->body = $_POST;
                    break;

                case self::_PUT:
                    parse_str(file_get_contents("php://input"), $request->body);
                    break;

                case self::_DELETE:
                    parse_str(file_get_contents("php://input"), $request->body);
                    break;
                
                default:
                    # code...
                    break;
            }

            return $request;
        }

        protected function processing(Entity $data) : RequestEntity
        {
            return $this->handle($_SERVER);
        }
    }

?>