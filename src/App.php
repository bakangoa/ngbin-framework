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
            $this->routes[HttpMethod::$update] = [];
            $this->routes[HttpMethod::$delete] = [];

            $this->pipeline = new Pipeline();

            $this->preprocessing = [
                "request" => new RequestHandler()
            ];
            $this->postprocessing = [];
        }

        public function addGetRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$get, $path, $class, $function);
        }

        public function addPostRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$post, $path, $class, $function);
        }

        public function addUpdateRoute(String $path, String $class, $function)
        {
            $this->addRoute(HttpMethod::$update, $path, $class, $function);
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