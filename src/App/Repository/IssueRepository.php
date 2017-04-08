<?php

namespace App\Repository;

use Mvc\DataQuery;
use App\Models\IssueModel;
use App\Entity\Tag;
use App\Entity\TagToIssue;

class IssueRepository extends DataQuery {

    public function getListLimited($start, $length, $order) {

        $query = $this->createQuery("Issue")
                ->whereUserId($this->user_id)
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

        $Data = $this->createRepo("Issue")->findResult(["issue_id" => $id, "user_id" => $this->user_id]);

        return $Data;
    }

    public function saveIssue($entity) {

        $save = $this->createInsert($entity);
        $issue_id = $save->getIssueId();

        $this->saveIssueTags($issue_id, $entity);
    }

    public function updateIssue($entity) {

        $save = $this->createUpdate($entity);
        $issue_id = $save->getIssueId();

        $this->deleteIssueTags($issue_id, $entity);
        $this->saveIssueTags($issue_id, $entity);
    }

    private function saveIssueTags($issue_id, $entity) {

        $tags = $entity->getTags();

        //Kullanıcının girdiği tag'leri explode ediyor
        if ($tags) {
            $q_tags = explode(',', $tags);
        }

        //Girilen tag'ler tag tablomuzda var mı, bakıyor ve tag index i ile yeni bir dizi oluşturuyor..
        $tagsRecords = $this->createQuery("Tag")->whereIn("tag", $q_tags)->getResultSet(false);
        $tagsRecordsIndexed = [];
        foreach ($tagsRecords as $index => $record) {
            $tagsRecordsIndexed[$record["tag"]] = $record;
        }

        //Kullanıcının girdiği etiketler daha önceden eklenmemişse tag tablosuna ekliyor ve relation tablosuna da tüm tagler için kayıt atıyor.
        foreach ($q_tags as $tag) {
            if (isset($tagsRecordsIndexed[$tag])) {
                $tag_id = $tagsRecordsIndexed[$tag]["tag_id"];
            } else {
                $tagEntity = new Tag();
                $tagEntity->setTag($tag);
                $saveTag = $this->createInsert($tagEntity);
                $tag_id = $saveTag->getTagId();
            }

            $tagToIssueEntity = new TagToIssue();
            $tagToIssueEntity->setTagId($tag_id);
            $tagToIssueEntity->setIssueId($issue_id);

            $saveTagToIssue = $this->createInsert($tagToIssueEntity);
        }
    }

    private function deleteIssueTags($issue_id, $entity) {

        $deleteTagToIssue = $this->deleteRecord("TagToIssue")
                ->whereIssueId($issue_id)->executeQuery();

        if ($deleteTagToIssue) {
            return true;
        } else {
            return false;
        }
    }

    public function getOldestIssues() {
        $query = $this->createQuery("Issue")
                ->order("created_at", "asc")
                ->whereUserId($this->user_id)
                ->whereStatus(1)
                ->limit(0, 10);

        $Data = $query->getResultSet(false);

        return $Data;
    }

    public function getIssuesByStatus($status = null) {

        $query = $this->createQuery("Issue")
                ->whereUserId($this->user_id);

        if (!is_null($status)) {
            $query = $query->whereStatus($status);
        }

        $Data = $query->getResultSet(false);

        return $Data;
    }
    
    public function getIssuesByTagsMost() {
        
        $sql = 'SELECT * from ism_tag as tags '
                . 'INNER JOIN (SELECT count(tag_id) as count,tag_id FROM `ism_tag_to_issue` group by tag_id HAVING count > 0 order by count DESC LIMIT 10) as ti ON ti.tag_id = tags.tag_id';
        $query = $this->createRawQuery($sql);

        $Data = $query->rawResults(false);
print_r($Data);exit;
        return $Data;
    }
    

}
