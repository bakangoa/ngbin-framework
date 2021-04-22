<?php

    namespace Ngbin\Framework;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Core\Enum\Method;
    use Ngbin\Framework\Core\Worker;
    use Ngbin\Framework\Worker\Launcher;
    use Ngbin\Framework\Worker\RequestHandler;
    use Ngbin\Framework\Worker\ResponseSender;
    use Ngbin\Framework\Worker\Router;

    /**
     * The app class
     */
    class App {

        /**
         * Routes defined by user
         * @var Array
         */
        private $routes;
        /**
         * The pipeline of workers
         * @var Pipeline
         */
        private $pipeline;

        /**
         * Contains the workers defined by user whose must be run just after the RequestHandler and before the Router
         * @var Array
         */
        private $preprocessing;
        /**
         * Contains the worker defined by user whose must be run just after the Launcher and before the Response
         * @var Array
         */
        private $postprocessing;

        public function __construct() {
            $this->routes = [];
            $this->routes[Method::$get] = [];
            $this->routes[Method::$post] = [];
            $this->routes[Method::$put] = [];
            $this->routes[Method::$delete] = [];

            $this->pipeline = new Pipeline();

            $this->preprocessing = [
                "request" => new RequestHandler()
            ];
            $this->postprocessing = [];
        }

        /**
         * Get a function format from a given argument
         * @param mixed $function
         * 
         * @return Array
         */
        private function getFunction($function) : Array
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

        /**
         * Handle get request
         * @param String $path
         * @param mixed $function
         * 
         * @return void
         */
        public function get(String $path, $function)
        {
            $action = $this->getFunction($function);
            $this->addGetRoute($path, $action['class'], $action["function"]);
        }

        /**
         * Handle post request
         * @param String $path
         * @param mixed $function
         * 
         * @return void
         */
        public function post(String $path, $function)
        {
            $action = $this->getFunction($function);
            $this->addPostRoute($path, $action['class'], $action["function"]);
        }

        /**
         * Handle put request
         * @param String $path
         * @param mixed $function
         * 
         * @return void
         */
        public function put(String $path, $function)
        {
            $action = $this->getFunction($function);
            $this->addPutRoute($path, $action['class'], $action["function"]);
        }

        /**
         * Handle delete request
         * @param String $path
         * @param mixed $function
         * 
         * @return void
         */
        public function delete(String $path, $function)
        {
            $action = $this->getFunction($function);
            $this->addDeleteRoute($path, $action['class'], $action["function"]);
        }

        /**
         * Add get route
         * @param String $path
         * @param String $class
         * @param mixed $function
         * 
         * @return void
         */
        public function addGetRoute(String $path, String $class, $function)
        {
            $this->addRoute(Method::$get, $path, $class, $function);
        }

        /**
         * Add post route
         * @param String $path
         * @param String $class
         * @param mixed $function
         * 
         * @return void
         */
        public function addPostRoute(String $path, String $class, $function)
        {
            $this->addRoute(Method::$post, $path, $class, $function);
        }

        /**
         * Add put route
         * @param String $path
         * @param String $class
         * @param mixed $function
         * 
         * @return void
         */
        public function addPutRoute(String $path, String $class, $function)
        {
            $this->addRoute(Method::$put, $path, $class, $function);
        }

        /**
         * Add delete route
         * @param String $path
         * @param String $class
         * @param mixed $function
         * 
         * @return void
         */
        public function addDeleteRoute(String $path, String $class, $function)
        {
            $this->addRoute(Method::$delete, $path, $class, $function);
        }

        /**
         * Put a route into app routes
         * @param String $method
         * @param String $path
         * @param String $class
         * @param mixed $function
         * 
         * @return void
         */
        private function addRoute(String $method, String $path, String $class, $function)
        {
            $this->routes[$method][$path] = [
                'class' => $class,
                'function' => $function
            ];
        }

        /**
         * Add a preprocess
         * @param String $name
         * @param Worker $worker
         * 
         * @return void
         */
        public function addPreProcess(String $name, Worker $worker)
        {
            $this->preprocessing[$name] = $worker;
        }

        /**
         * Remove a preprocess
         * @param String $name
         * @param Worker $worker
         * 
         * @return void
         */
        public function removePreProcess(String $name, Worker $worker)
        {
            unset($this->preprocessing[$name]);
        }

        /**
         * Add a post process
         * @param String $name
         * @param Worker $worker
         * 
         * @return void
         */
        public function addPostProcess(String $name, Worker $worker)
        {
            $this->postprocessing[$name] = $worker;
        }

        /**
         * Remove a post process
         * @param String $name
         * @param Worker $worker
         * 
         * @return void
         */
        public function removePostProcess(String $name, Worker $worker)
        {
            unset($this->postprocessing[$name]);
        }

        /**
         * Run the app
         * @return void
         */
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

            $this->pipeline->add(new ResponseSender());

            try {
                $response = $this->pipeline->start(Entity::empty(), true);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

    }

?>