<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
use Ngbin\Framework\Core\Enum\ContentType;
use Ngbin\Framework\Core\Enum\HeaderName;
use Ngbin\Framework\Core\Enum\Method;
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
                case Method::$get:
                    $request->query = $_GET;
                    break;

                case Method::$post:
                    $headers = getallheaders();
                    if (!empty($headers[HeaderName::$content_type]))
                    {
                        $type = ContentType::$json;
                        try {
                            if (\str_starts_with($headers[HeaderName::$content_type], $type))
                            {
                                $request->body = (Array)json_decode(file_get_contents('php://input'));
                                break;
                            }
                        } catch (\Exception $e) {
                            $request->body = $_POST;
                            break;
                        }
                        
                    }
                    $request->body = $_POST;
                    break;

                case Method::$put:
                    parse_str(file_get_contents("php://input"), $request->body);
                    break;

                case Method::$delete:
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