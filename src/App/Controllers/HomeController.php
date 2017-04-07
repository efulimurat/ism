<?php

namespace App\Controllers;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController {
    
    public function dashboard(Request $request,Application $app){
        
        return $app['twig']->render('dashboard.html.twig');
    }
}

?>