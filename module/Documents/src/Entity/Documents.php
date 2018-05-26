<?php
namespace Documents\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Этот класс представляет собой пост в блоге.
 * @ORM\Entity(repositoryClass="\Documents\Repository\DocumentsRepository")
 * @ORM\Table(name="documents")
 */


class Documents 
{
   
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="number")  
     */
    protected $number;
    /** 
     * @ORM\Column(name="name")  
     */
    protected $name;
    /** 
     * @ORM\Column(name="depart_issue")  
     */
    protected $depart_issue;
    /** 
     * @ORM\Column(name="date_issue")  
     */
    protected $date_issue;
    /** 
     * @ORM\Column(name="author")  
     */
    protected $author;
   
   
 
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getNumber() 
    {
        return $this->number;
    }

    public function setNumber($number) 
    {
        $this->number = $number;
    }
    
   
    public function getName() 
    {
        return $this->name;
    }       

    public function setName($name) 
    {
        $this->name = $name;
    }
   
    public function getDepartIssue() 
    {
        return $this->depart_issue;
    }
    public function setDepartIssue($depart_issue) 
    {
        $this->depart_issue = $depart_issue;
    }

    public function getDateIssue() 
    {
        return $this->date_issue;
    }
   
    public function setDateIssue($date_issue) 
    {
        $this->date_issue = $date_issue;
    }    
    
    public function getAuthor()
    {
        return $this->author;
    }
  
    public function setAuthor($author) 
    {
        $this->author = $author;
    }
    
   
}





