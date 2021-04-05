<?php

    namespace Ngbin\Framework\Core;

    abstract class Worker
    {

        private $next;

        public function getNext() : mixed
        {
            return $this->next;
        }

        public function setNext(Worker $next)
        {
            $this->next = $next;
        }

        protected abstract function processing(Entity $entity) : Entity;

        public function run(mixed $data, bool $rewrite_data = false) : mixed
        {
            $result = $this->processing($data);

            if (empty($this->next))
            {
                return $result;
            }

            if ($rewrite_data)
            {
                $data = $result;
            }

            return $this->next->run($data, $rewrite_data);
        }

    }

?>