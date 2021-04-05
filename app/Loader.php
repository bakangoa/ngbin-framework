<?php

    namespace Goa\Ngbinfwk;

    class Loader
    {

        public static function loadDir(String $folder)
        {
            foreach (glob($folder . "/*.php") as $filename) {
                require_once $filename;
            }
        }

        public static function loadFiles(Array $directories)
        {
            foreach ($directories as $directory) {
                Loader::loadDir($directory);
            }
        }
    }

?>