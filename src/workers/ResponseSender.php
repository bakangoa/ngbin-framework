<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\Response;

    /**
     * A worker which create a Response
     */
    class ResponseSender extends \Ngbin\Framework\Core\Worker
    {

        protected function process(Entity $data) : Response
        {
            return new Response($data);
        }

    }

?>