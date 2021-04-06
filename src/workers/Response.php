<?php

    namespace Ngbin\Framework\Worker;

use Ngbin\Framework\Core\Entity;
use Ngbin\Framework\Entity\ResponseEntity;

    class Response extends \Ngbin\Framework\Core\Worker
    {

        protected function processing(Entity $data) : ResponseEntity
        {
            return new ResponseEntity($data);
        }

    }

?>