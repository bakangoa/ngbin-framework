<?php

    namespace Ngbin\Framework;

    use Ngbin\Framework\Core\Worker;

    class Pipeline
    {

        private $head_worker;

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

        public function start(mixed $data, bool $rewrite_data = false)
        {
            return $this->head_worker->run($data, $rewrite_data);
        }   
    }

?>