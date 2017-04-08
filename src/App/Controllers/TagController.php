<?php

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\Issue;
use App\Models\IssueModel;
use App\Repository\IssueRepository;

class TagController extends BaseController {

    function __construct(Request $request, Application $app) {
        parent::__construct($request, $app);
    }

    public function getListById($tag_id) {
        return $this->app['twig']->render('tag/list.html.twig', ["tag_id" => (int) $tag_id]);
    }

    public function getListByIdData($tag_id) {

        $length = (int) $this->request->get("length");
        $start = (int) $this->request->get("start");

        if ($length > 100) {
            $length = 100;
        }

        $orderCol = $this->request->get('order')[0]['column'];
        $orderDir = $this->request->get('order')[0]['dir'];

        switch ($orderCol) {
            case 1:
            default:
                $orderBy = "created_at";
                break;
            case 2:
                $orderBy = "updated_at";
                break;
        }

        if (!in_array($orderDir, ["asc", "desc"])) {
            $orderDir = "asc";
        }

        $Issue = new IssueRepository();
        $Issue->cacheKey = "IssuesByTagId";
        $Issue->cacheTimeout = 0;

        $response = $Issue->getListByTagId((int) $tag_id, $start, $length, [$orderBy, $orderDir]);

        return $this->app->json($response);
    }

}

?>