<?php

    require_once "app/autoload.php";

    Goa\Ngbinfwk\Loader::loadFiles([
        "controllers"
    ]);

    $app = new \Ngbin\Framework\App();

    $app->addGetRoute("/ngbin-framework", "", function () {
        return "Hello Nanok";
    });

    $app->run();

?>