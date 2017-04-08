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

class IssueController extends BaseController {

    function __construct(Request $request, Application $app) {
        parent::__construct($request, $app);
    }

    public function add() {

        $issue = new Issue();

        $form = $this->getForm($this->app['form.factory'], $issue);

        if ($this->checkFormFor("save", $form, $issue)) {
            return $this->redirect("issue.list");
        }

        return $this->app['twig']->render('issue/add.html.twig', array('form' => $form->createView()));
    }

    public function edit($issue_id) {

        $Issue = new IssueRepository();
        $Issue->cacheKey = "getIssue" . $issue_id;
        $Issue->cacheTimeout = 30;
        $issue = $Issue->getIssue($issue_id);

        if (!$issue) {
            return $this->app->abort(404);
        }
        $form = $this->getForm($this->app['form.factory'], $issue, "update");

        if ($this->checkFormFor("update", $form, $issue)) {
            return $this->redirect("issue.list");
        }

        return $this->app['twig']->render('issue/edit.html.twig', array('status' => $issue->getStatus(), 'form' => $form->createView()));
    }

    public function getList() {
        return $this->app['twig']->render('issue/list.html.twig', ["ajaxUrl" => $this->routePath("issue.ajax.url")]);
    }

    public function getListData() {

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
        $Issue->cacheKey = "IssuesListLimited";
        $Issue->cacheTimeout = 30;

        $response = $Issue->getListLimited($start, $length, [$orderBy, $orderDir]);

        return $this->app->json($response);
    }

    public function updateIssueStatus() {
        $id = (int) $this->request->request->get("id");
        if (!$id) {
            return $this->app->abort(404);
        }

        $Issue = new IssueRepository();
        $Issue->cacheKey = "getIssue" . $id;
        $Issue->cacheTimeout = 30;
        $issue = $Issue->getIssue($id);

        if ($issue->getStatus() == 1) {
            $issue->setStatus(0);
            $issue->setUpdatedAt();
        }
        return $this->app->json(["result" => "success"]);
    }

    private function getForm($formProvider, $issue, $act = null) {
        $formBuilder = $formProvider->createBuilder(FormType::class, $issue)
                ->add('title')
                ->add('content', TextareaType::class, ["attr" => ["rows" => 5]])
                ->add('tags', null, ["required" => false]);
        if ($act == "update") {
            if ($issue->getStatus() == 0) {
                $formBuilder = $formBuilder->add('status', CheckboxType::class, ["required" => false, "disabled" => true]);
            } else {
                $formBuilder = $formBuilder->add('status', CheckboxType::class, ["required" => false]);
            }
            $formBuilder = $formBuilder->add('title', null, ['disabled' => true]);
        }
        return $formBuilder->getForm();
    }

    private function checkFormFor($action, $form, $issue) {
        $form->handleRequest($this->request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($action == "save") {
                $issue->setUserId(61);
                $issue->setStatus(1);
                $issue->setCreatedAt();
                $issue->setUpdatedAt();
            } elseif ($action == "update") {
                //Kapanmış ise, tekrar açamasın
                if ($issue->getStatus() == false) {
                    $issue->setStatus(0);
                } else {
                    //Açıksa status post'a bak.. eğer kapatılıyorsa updated_at güncelle : Kapanış tarihi
                    if (!$this->request->request->get("form")["status"] == 1) {
                        $issue->setUpdatedAt();
                    }
                }
            }
            $Issue = new IssueRepository();
            return $Issue->saveIssue($issue);

            return true;
        }
        return false;
    }

}

?>