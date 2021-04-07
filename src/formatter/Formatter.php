<?php

    namespace Ngbin\Framework\Formatter;

    interface Formatter
    {
        /**
         * Format a data
         * @param mixed $data
         * 
         * @return mixed
         */
        public function format($data);
    }

?>