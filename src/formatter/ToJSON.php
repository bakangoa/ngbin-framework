<?php

    namespace Ngbin\Framework\Formatter;

    /**
     * This class which can be used to convert a array or object into JSON
     */
    class ToJSON implements Formatter
    {
        
        public function format($data)
        {
            return json_encode($data);
        }
    }
    

?>