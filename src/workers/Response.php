<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\ResponseEntity;

    /**
     * A worker which create a ResponseEntity
     */
    class Response extends \Ngbin\Framework\Core\Worker
    {

        protected function processing(Entity $data) : ResponseEntity
        {
            return new ResponseEntity($data);
        }

    }

?>