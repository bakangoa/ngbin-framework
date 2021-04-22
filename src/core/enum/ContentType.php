<?php

    namespace Ngbin\Framework\Core\Enum;

    /**
     * A class which contains the content type different values
     */
    class ContentType 
    {
        /**
         * JSON content type
         * @var string
         */
        public static $json = "application/json";
        /**
         * Form url encoded content type
         * @var string
         */
        public static $urlencoded = "application/x-www-form-urlencoded";
        /**
         * Multipart form data content type
         * @var string
         */
        public static $form_data = "multipart/form-data";
        /**
         * Text plain content type
         * @var string
         */
        public static $text = "text/plain";
        /**
         * Xml text content type
         * @var string
         */
        public static $xml = "text/xml";
        /**
         * Html text content type
         * @var string
         */
        public static $html = "text/html";
    }

?>