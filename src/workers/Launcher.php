<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\ContentEntity;
use Ngbin\Framework\Entity\Response;

/**
     * A worker which execute a function
     */
    class Launcher extends \Ngbin\Framework\Core\Worker
    {
        protected function process(Entity $data) : Response
        {
            if (!empty($data->class))
            {
                $controller = new $data->class();
                $response = $controller->{$data->method}($data->request);

                return $this->getResponse($response);
            }

            if (is_callable($data->method))
            {
                $response = call_user_func($data->method, $data->request);
                return $this->getResponse($response);
            }
            
            return $this->getResponse(null);
        }

        /**
         * Get a Response object
         * @param mixed $response
         * 
         * @return Response
         */
        private function getResponse($response) : Response
        {
            if ($response == null)
            {
                return new Response(null, null, 404);
            }

            if (is_object($response) && is_a($response, "Ngbin\Framework\Entity\Response"))
            {
                return $response;
            }

            return new Response(null, null, 500);
        }
    }

?>