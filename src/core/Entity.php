<?php

    namespace Ngbin\Framework\Core;

    /**
     * The type of objects which transit in the pipeline
     */
    class Entity
    {
        /**
         * Create an empty Entity
         * @return Entity
         */
        public static function empty()
        {
            return new Entity();
        }
    }

?>