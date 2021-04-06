<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\RequestEntity;

    class RequestHandler extends \Ngbin\Framework\Core\Worker
    {

        const _GET = "GET";
        const _POST = "POST";
        const _UPDATE = "UPDATE";
        const _DELETE = "DELETE";

        const _URI = "REQUEST_URI";
        const _METHOD = "REQUEST_METHOD";

        public function handle($data) : RequestEntity
        {
            $request = new RequestEntity($data[self::_URI], $data[self::_METHOD]);

            switch ($data['REQUEST_METHOD']) {
                case self::_GET:
                    $request->params = $_GET;
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