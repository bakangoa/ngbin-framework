<?php
    require_once "vendor/autoload.php";

    use Ngbin\Framework\App;
    use Ngbin\Framework\Entity\Request;
    use Ngbin\Framework\Entity\Response;
    use Ngbin\Framework\Formatter\ToJSON;

    /**
     * Just a test class
     */
    class A {

        /**
         * Say Hello to someone
         * @param Request $request
         * 
         * @return String
         */
        public function hello(Request $request)
        {
            $firstname = (!empty($request->query['firstname'])) ? $request->query['firstname'] : "";
            return "Hello " . $request->params['name'] . $firstname;
        }
    }

    $app = new App();

    /* $app->get("/", function () {
        return "Hello World";
    }); */

    //$app->get("/:name", ["A", "hello"]);
    $app->get("/", function () {
        return "Hello world";
    });

    $app->get("/json", function (Request $request)
    {
        return new Response([
            "key" => "value"
        ], new ToJSON());
    });

    $app->run();

?>