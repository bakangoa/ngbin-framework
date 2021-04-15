<?php

    namespace Ngbin\Framework\Worker;

    use Ngbin\Framework\Core\Entity;
    use Ngbin\Framework\Entity\ContentEntity;

    /**
     * A worker which execute a function
     */
    class Launcher extends \Ngbin\Framework\Core\Worker
    {
        protected function process(Entity $data) : ContentEntity
        {
            if (!empty($data->class))
            {
                $controller = new $data->class();
                return new ContentEntity($controller->{$data->method}($data->request));
            }

            if (is_callable($data->method))
            {
                return new ContentEntity(call_user_func($data->method, $data->request));
            }
            
            return new ContentEntity(null, 404);
        }
    }

?>