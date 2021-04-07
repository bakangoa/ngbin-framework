<?php

    namespace Ngbin\Framework;

    use Ngbin\Framework\Core\Worker;

    /**
     * A pipeline of workers
     */
    class Pipeline
    {

        /**
         * The head of the list of worker
         * @var Worker
         */
        private $head_worker;

        /**
         * Add a worker to pipeline
         * @param Worker $worker
         * 
         * @return void
         */
        public function add(Worker $worker)
        {
            if (empty($this->head_worker))
            {
                $this->head_worker = $worker;
                return;
            }


            $temp = $this->head_worker;
            while ($temp->getNext() != null)
            {
                $temp = $temp->getNext();
            }

            $temp->setNext($worker);
        }

        /**
         * Run the chain of workers
         * @param mixed $data
         * @param bool $rewrite_data
         * 
         * @return Entity
         */
        public function start($data, bool $rewrite_data = false)
        {
            return $this->head_worker->run($data, $rewrite_data);
        }   
    }

?>