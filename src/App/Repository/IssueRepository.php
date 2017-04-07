<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository{
    
    public function deneme(){
        return "yihuuu";
    }
}