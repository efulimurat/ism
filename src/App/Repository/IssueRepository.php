<?php

namespace App\Repository;

use Mvc\DataQuery;
use App\Models\IssueModel;

class IssueRepository extends DataQuery {

    public function getListLimited($start, $length, $order) {

        $query = $this->createQuery("Issue")
                ->order($order[0], $order[1])
                ->limit($start, $length);

        $Data = $query->getResultSet();

        $issueModel = new IssueModel();

        $response['recordsTotal'] = $Data["total_count"];
        $response['recordsFiltered'] = $Data["total_count"];
        $response['data'] = aliases($issueModel, $Data["data"]);

        return $response;
    }

    public function getIssue($id) {

        $Data = $this->createRepo("Issue")->findResult($id);

        return $Data;
    }

    public function saveIssue($entity) {
        return $this->createInsert($entity);
    }

}
