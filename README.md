# ngbin-framework
Ngbin framework is a PHP micro framework developed to introduce a new way to handle and process http request

# How to install ?

Just run the command "composer require bakangoa/ngbin-framework".

# How to use ?

Create in your code an instance of "Ngbin\Framework\App". 
Add to this instance some worker, routes and call method run to start your app.

# Example

A service which return "Hello world" when his route "GET /" is called
```php
$app = new App();

$app->get("/", function (Request $req) {
    return new Response("Hello world");
});

$app->run();
```

Official documentation at https://bakangoa.github.io/ngbin-framework/
