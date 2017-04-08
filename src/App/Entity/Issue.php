<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="ism_issue")
 * @ORM\Entity(repositoryClass="App\Repository\IssueRepository")
 **/
class Issue
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $issue_id;
    
    /** @Column(type="integer") **/
    protected $user_id;
    
    /** @Column(type="string") **/
    protected $title;
    
    /** @Column(type="text") **/
    protected $content;
    
    /** @Column(type="text") **/
    protected $tags;
    
    /** @Column(type="datetime") **/
    protected $created_at;
    
    /** @Column(type="datetime") **/
    protected $updated_at;
    
    /** @Column(type="integer") **/
    protected $status;
    
    
    public function getIssueId()
    {
        return $this->issue_id;
    }

    public function getUserId()
    {
        return $this->title;
    }

    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
    
     public function getStatus()
    {
         if($this->status == 0){
             return false;
         }
         else{
             return true;
         }
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
     public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt()
    {
         $this->created_at = new \DateTime("now");
    }
    
    public function getUpdatedAt()
    {
        return $this->created_at;
    }

    public function setUpdatedAt()
    {
         $this->updated_at = new \DateTime("now");
    }
    
    
}
?>