<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="ism_tag_to_issue")
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 **/
class TagToIssue
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $tag_to_issue_id;
    
    /** @Column(type="integer") **/
    protected $tag_id;
   
    /** @Column(type="integer") **/
    protected $issue_id;
    
    public function getTagToIssueId()
    {
        return $this->tag_to_issue_id;
    }

    
    public function getTagId()
    {
        return $this->tag_id;
    }

    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;
    }
    
     public function getIssueId()
    {
        return $this->issue_id;
    }

    public function setIssueId($issue_id)
    {
        $this->issue_id = $issue_id;
    }
   
}
?>