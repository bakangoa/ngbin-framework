<?php

    namespace Ngbin\Framework;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Core\HttpMethod;
    use Ngbin\Framework\Core\Worker;
    use Ngbin\Framework\Worker\Launcher;
    use Ngbin\Framework\Worker\RequestHandler;
    use Ngbin\Framework\Worker\Response;
    use Ngbin\Framework\Worker\Router;

    class App {

        private $routes;
        private $pipeline;

        private $preprocessing;
        private $postprocessing;

        public function __construct() {
            $this->routes = [];
            $this->routes[HttpMethod::$get] = [];
            $this->routes[HttpMethod::$post] = [];
            $this->routes[HttpMethod::$put] = [];
            $this->routes[HttpMethod::$delete] = [];

            $this->pipeline = new Pipeline();

            $this->preprocessing = [
                "request" => new RequestHandler()
            ];
            $this->postprocessing = [];
        }

        private function getFunction(mixed $function) : Array
        {
            $class = "";

            if (is_array($function) && count($function) >= 2)
            {
                $class = $function[0];
                $function = $function[1];
            }

            return [
                'class' => $class,
                'function' => $function
            ];
        }

        public function get(String $path, mixed $function)
        {
            $action = $this->getFunction($function);
            $this->addGetRoute($path, $action['class'], $action["function"]);
        }

        public function post(String $path, mixed $function)
        {
            $action = $this->getFunction($function);
            $this->addPostRoute($path, $action['class'], $action["function"]);
        }

        public function put(String $path, mixed $function)
        {
            $action = $this->getFunction($function);
            $this->addPutRoute($path, $action['class'], $action["function"]);
        }

        public function delete(String $path, mixed $function)
        {
            $action = $this->getFunction($function);
            $this->addDeleteRoute($path, $action['class'], $action["function"]);
        }

        public function addGetRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$get, $path, $class, $function);
        }

        public function addPostRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$post, $path, $class, $function);
        }

        public function addPutRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$put, $path, $class, $function);
        }

        public function addDeleteRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$delete, $path, $class, $function);
        }

        private function addRoute(String $method, String $path, String $class, $function)
        {
            $this->routes[$method][$path] = [
                'class' => $class,
                'function' => $function
            ];
        }

        public function addPreProcess(String $name, Worker $worker)
        {
            $this->preprocessing[$name] = $worker;
        }

        public function removePreProcess(String $name, Worker $worker)
        {
            unset($this->preprocessing[$name]);
        }

        public function addPostProcess(String $name, Worker $worker)
        {
            $this->postprocessing[$name] = $worker;
        }

        public function removePostProcess(String $name, Worker $worker)
        {
            unset($this->postprocessing[$name]);
        }

        public function run()
        {
            foreach ($this->preprocessing as $key => $value) {
                $this->pipeline->add($value);
            }
            $this->pipeline->add(new Router($this->routes));
            $this->pipeline->add(new Launcher());

            foreach ($this->postprocessing as $key => $value) {
                $this->pipeline->add($value);
            }

            $this->pipeline->add(new Response());

            try {
                $response = $this->pipeline->start(Entity::empty(), true);
                $response->end();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

    }

?>