<?php

namespace App;

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Mvc\CacheComponent;
use Doctrine\ORM\Tools\Setup;
use Mvc\DataQuery;

class app {

    public static function init() {
        global $params;
        $app = new Application();
        
        $app["debug"] = true;
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new AssetServiceProvider());
        $app->register(new TwigServiceProvider());
        $app->register(new HttpFragmentServiceProvider());
        $app->register(new CsrfServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new LocaleServiceProvider());
        $app->register(new \Silex\Provider\RoutingServiceProvider());
        $app->register(new TranslationServiceProvider(), array(
            'locale_fallbacks' => array('en'),
        ));
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/../../views',
        ));
        $app['twig'] = $app->extend('twig', function ($twig, $app) {
            return $twig;
        });

        $app->register(new DoctrineServiceProvider(), array(
            'db.options' => $params["db"],
        ));
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), false);

        DataQuery::createEM($app["db"], $config);

        //Redis Conf
        CacheComponent::setConf([
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379
        ]);

        $request = new \Symfony\Component\HttpFoundation\Request;

        //Controllers
        $app['controller.main'] = function ($request) use ($app) {
            return new \App\Controllers\MainController($request['request_stack']->getCurrentRequest(), $app);
        };
        $app['controller.issue'] = function ($request) use ($app) {
            return new \App\Controllers\IssueController($request['request_stack']->getCurrentRequest(), $app);
        };
       
        $app['controller.tag'] = function ($request) use ($app) {
            return new \App\Controllers\TagController($request['request_stack']->getCurrentRequest(), $app);
        };

        $app->get('/', 'controller.main:dashboard')->bind("homepage");
        $app->get('/issues/', 'controller.issue:getList')->bind('issue.list');
        $app->get('/issues/ajax', 'controller.issue:getListData')->bind('issue.ajax.url');
        $app->post('/issues/updateStatus', 'controller.issue:updateIssueStatus')->bind('issue.update.status');
        $app->match('/add_issue/', 'controller.issue:add')->bind('issue.add');
        $app->match('/edit_issue/{issue_id}', 'controller.issue:edit')->assert('issue_id', '\d+')->bind('issue.edit');
        $app->get('/tags/{tag_id}', 'controller.tag:getListById')->assert('tag_id', '\d+')->bind('tag.search');
        $app->get('/tags/ajax{tag_id}', 'controller.tag:getListByIdData')->assert('tag_id', '\d+')->bind('tag.ajax.url');


        $app['version'] = 2;
        $app['domain'] = "ism.com";
        $app['is_secure'] = $request->isSecure();
        $app['http_protocol'] = $app['is_secure'] ? "https://" : "http://";
        $app['app_url'] = $app['http_protocol'] . $app['domain'] . "/";
        $app['web_path'] = "/public";

        return $app;
    }

}