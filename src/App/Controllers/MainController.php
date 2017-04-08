<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Issue;
use App\Models\IssueModel;
use App\Repository\IssueRepository;

class MainController extends BaseController {

    function __construct(Request $request, Application $app) {
        parent::__construct($request, $app);
    }

    public function dashboard() {

        $Issue = new IssueRepository();

        $Issue->cacheKey = "IssuesOldest";
        $Issue->cacheTimeout = 120;
        $oldestIssues = $Issue->getOldestIssues();

        $Issue->cacheKey = "openIssuesCount";
        $Issue->cacheTimeout = 120;
        $openIssues = $Issue->getIssuesByStatus(1);
        
        $Issue->cacheKey = "allIssuesCount";
        $Issue->cacheTimeout = 120;
        $allIssues = $Issue->getIssuesByStatus();

        //Issue Sayıları
        $totalIssues = count($allIssues);
        $openIssues = count($openIssues);
        $closedIssues = $totalIssues - $openIssues;
        
        //En çok ıssue olan tag'ler
        $Issue->cacheKey = "mostTagIssues";
        $Issue->cacheTimeout = 120;
        $tagIssues = $Issue->getIssuesByTagsMost();


        return $this->app['twig']->render('main/dashboard.html.twig', ['openIssues' => $openIssues, "totalIssues" => $totalIssues, "closedIssues" => $closedIssues, "oldestIssues" => $oldestIssues]);
    }

}

?>