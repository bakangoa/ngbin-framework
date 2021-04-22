<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\Response;

    /**
     * A worker which create a Response
     */
    class ResponseSender extends \Ngbin\Framework\Core\Worker
    {

        protected function process(Entity $response) : Response
        {
            $this->setHeaders($response);
            $this->send($response);
            return $response;
        }

        /**
         * Send the response
         * @return void
         */
        public function send(Response $response)
        {
            echo $response->getContent();
        }

        /**
         * Set all the response headers
         * @param Response $response
         * 
         * @return void
         */
        private function setHeaders(Response $response)
        {
            foreach ($response->getHeaders() as $key => $header) {
                header($header->getName() . ":" . $header->getValue());
            }
        }

    }

?>