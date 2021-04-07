<?php

    namespace Ngbin\Framework\Core;

    /**
     * Represent a process in the pipeline
     */
    abstract class Worker
    {

        /**
         * The next worker
         * @var Worker
         */
        private $next;

        /**
         * Get the worker after this worker in the pipe
         * @return Worker
         */
        public function getNext()
        {
            return $this->next;
        }

        /**
         * Set the worker after this worker in the pipe
         * @param Worker $next
         * 
         * @return void
         */
        public function setNext(Worker $next)
        {
            $this->next = $next;
        }

        /**
         * Function which contains instruction to execute when the worker run
         * @param Entity $entity
        * 
        * @return Entity
        */
        protected abstract function processing(Entity $entity) : Entity;

        /**
         * Function which start the execution to a chain of workers by starting from this worker
         * @param Entity $data
         * @param bool $rewrite_data
         * 
         * @return Entity
         */
        public function run(Entity $data, bool $rewrite_data = false)
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