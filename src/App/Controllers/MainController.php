<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Issue;
use App\Models\IssueModel;

class MainController extends BaseController {

    function __construct(Request $request, Application $app) {
        parent::__construct($request, $app);
    }

    public function dashboard() {
        //Issue Sayıları
        $totalIssues = $this->getCountIssuesQuery();
        $openIssues = $this->getCountIssuesQuery(0);
        $closedIssues = $totalIssues - $openIssues;

        //En eski ve açık kalan issue lar
        $oldestIssues = $this->getOldestIssues();

        return $this->app['twig']->render('main/dashboard.html.twig', ['openIssues' => $openIssues, "totalIssues" => $totalIssues, "closedIssues" => $closedIssues, "oldestIssues" => $oldestIssues]);
    }

    private function getCountIssuesQuery($status = null) {
        $query = $this->app["em"]->createQueryBuilder()->select("i")
                ->from("App\Entity\Issue", "i");

        if (!is_null($status)) {
            $query = $query->where("i.status = " . $status);
        }

        $countResults = count($query->getQuery()->getArrayResult());

        return $countResults;
    }

    private function getOldestIssues($limit = 5) {
        $query = $this->app["em"]->createQueryBuilder()->select("i")
                ->from("App\Entity\Issue", "i")
                ->orderBy("i.created_at", "asc")
                ->where("i.status = 1");

        $Data = $query->getQuery()->getArrayResult();

        return $Data;
    }

}

?>