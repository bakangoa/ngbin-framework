<?php

    require_once "app/autoload.php";

    $app = new \Ngbin\Framework\App();

    $app->addGetRoute("/ngbin-framework", "", function () {
        return "Hello World";
    });

    $app->run();

?>