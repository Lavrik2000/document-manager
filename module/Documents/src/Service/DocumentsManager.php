<?php
namespace Documents\Service;

use Documents\Entity\Documents;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;


/**
 * This service is responsible for adding/editing/deleting documents
 * .
 */
class DocumentsManager
{
   
    private $entityManager; 
    private $authService;
    
    
    public function __construct($entityManager,$authService) 
    {
        $this->entityManager = $entityManager;
         $this->authService = $authService;
        
    }
    

    public function addDocuments($data) 
    {
        // Create new Documents entity.
        $document = new Documents();
        $document->setNumber($data['number']);
        $document->setName($data['name']);
        $document->setDepartIssue($data['depart_issue']);
        $document->setDateIssue($data['date_issue']);
        $document->setAuthor($this->authService->getIdentity());
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($document);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $document;
    }
    
    /**
     * This method updates data of an existing document.
     */
    public function updateDocuments($document, $data) 
    {
               
       
        $document->setNumber($data['number']);
        $document->setName($data['name']);
        $document->setDepartIssue($data['depart_issue']);
        $document->setDateIssue($data['date_issue']);        
        
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    public function deleteDocuments($documents) 
    {
        
        $this->entityManager->remove($documents);
        
        $this->entityManager->flush();
        
        return $document;
    }
    
 
}

