<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\RequestEntity;
    use Ngbin\Framework\Entity\RouteEntity;

    /**
     * A worker to choose which function to run depending to request
     */
    class Router extends \Ngbin\Framework\Core\Worker
    {
        /**
         * Array which contains a list of routes for routing
         * @var Array
         */
        private $routes;

        /**
         * @param Array $routes
         */
        public function __construct(Array $routes) {
            $this->routes = $routes;
        }

        /**
         * Choose a route
         * @param RequestEntity $request
         * 
         * @return RouteEntity
         */
        private function chooseRoute(RequestEntity $request)
        {
            $routes = $this->routes[$request->method];
            foreach ($routes as $path => $route) {
                $params = $this->getRouteParams($path, $request->uri);
                if (!is_null($params))
                {
                    if (!empty($params))
                    {
                        $request->params = array_merge($request->params, $params);
                    }

                    return new RouteEntity($route['class'], $route['function'], $request);
                }
            }

            return new RouteEntity("", "", $request);
        }

        /**
         * Compare a path and an uri
         * @param String $path
         * @param String $uri
         * 
         * @return null|Array Array which contains eventual parameters when the path and the uri are same. null else
         */
        private function getRouteParams(String $path, String $uri)
        {
            $params = [];

            $get_params_position = strpos($uri, "?");
            if ($get_params_position != false)
            {
                $uri = substr($uri, 0, $get_params_position);
            }

            $path = trim($path, "/");
            $uri = trim($uri, "/");

            if ($path == $uri)
            {
                return $params;
            }

            $path = explode('/', $path);
            $uri = explode('/', $uri);

            if (count($path) != count($uri))
            {
                return null;
            }

            foreach ($path as $key => $value) {
                $param_position = strpos($value, ":");
                if ((is_bool($param_position) || $param_position != 0) && $value != $uri[$key])
                {
                    return null;
                }

                if (is_int($param_position) && $param_position == 0)
                {
                    $params[substr($value, 1)] = $uri[$key];
                }
            }

            return $params;
        }

        protected function processing(Entity $data) : RouteEntity
        {
            return $this->chooseRoute($data);
        }
    }

?>