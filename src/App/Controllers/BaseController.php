<?php

namespace App\Controllers;

abstract class BaseController {

    protected $app;
    protected $request;
    protected $user_id;

    function __construct($request, $app) {
        $this->app = $app;
        $this->request = $request;
        $user_id = \Mvc\Authenticate::getAuthUser();
        if ($user_id) {
            \Mvc\CacheComponent::addKey("UserId", $user_id);
            $this->user_id = $user_id;
        }
    }

    protected function redirect($routeName) {
        return $this->app->redirect($this->routePath($routeName));
    }

    protected function routePath($routeName) {
        return $this->app["url_generator"]->generate($routeName);
    }

}
