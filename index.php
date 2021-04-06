<?php


    require_once "vendor/autoload.php";

    use Ngbin\Framework\App;

    $app = new App();

    $app->addGetRoute("/ngbin-framework", "", function () {
        return "Hello World";
    });

    $app->run();

?>