<?php

    require_once "Loader.php";
    
    use Goa\Ngbinfwk\Loader;

    $directories =[
        "app/core",
        "app/entities",
        "app/workers"
    ];

    Loader::loadFiles($directories);

    require_once "app/Pipeline.php";
    require_once "app/App.php";

?>