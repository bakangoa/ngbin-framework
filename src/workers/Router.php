<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\RequestEntity;
    use Ngbin\Framework\Entity\RouteEntity;

    class Router extends \Ngbin\Framework\Core\Worker
    {
        private $routes;

        public function __construct(Array $routes) {
            $this->routes = $routes;
        }

        private function chooseRoute(RequestEntity $request) : mixed
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

        private function getRouteParams(String $path, String $uri) : mixed
        {
            $params = [];

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
                if ($param_position != 0 && $value != $uri)
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