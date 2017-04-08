<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="ism_tag")
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 **/
class Tag
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $tag_id;
    
    /** @Column(type="string") **/
    protected $tag;
    
    public function getTagId()
    {
        return $this->tag_id;
    }

    
    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }
   
}
?>