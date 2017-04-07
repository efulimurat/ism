<?php

namespace App\Controllers;

abstract class BaseController {

    protected $app;
    protected $request;

    function __construct($request, $app) {
        $this->app = $app;
        $this->request = $request;
    }

    protected function redirect($routeName) {
        return $this->app->redirect($this->routePath($routeName));
    }

    protected function routePath($routeName) {
        return $this->app["url_generator"]->generate($routeName);
    }

}
