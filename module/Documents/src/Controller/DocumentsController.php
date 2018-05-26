<?php
namespace Documents\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;
use Documents\Entity\Documents;
use Documents\Form\DocumentsForm;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;



/**
 * This controller is responsible for documents management (adding, editing, 
 * viewing docs).
 */
class DocumentsController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * User manager.
     * @var User\Service\DocumentsManager 
     */
    private $documentsManager;
    
    private $authManager;



    /**
     * Constructor. 
     */
    public function __construct($entityManager, $documentsManager,$authManager)
    {
        $this->entityManager = $entityManager;
        $this->documentsManager = $documentsManager;
        $this->authManager = $authManager;
       
    }
    
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * list of documents.
     */
    public function indexAction(){ 
        
             
        $page = $this->params()->fromQuery('page', 1);
        // проверка на использование пагинатора
        $use = $this->params()->fromQuery('use', 0);
        
        if ( $use!=0) {
            //извлечение параметров сущности, если использовался пагинатор
            $field = $this->params()->fromQuery('field', 0);
            $order = $this->params()->fromQuery('order', 0);
        }
        else{
            //извлечение параметров сущности, без пагинатора
               $id = $this->params()->fromRoute('id', '-1');       
               $field = $this->params()->fromRoute('field', 'id');            
               $order= $this->params()->fromRoute('order', 'ASC');
        }
        $query = $this->entityManager->getRepository(Documents::class)
                ->findDocuments($field,$order);
        
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(5);        
        $paginator->setCurrentPageNumber($page);
       
        $auth=$this->authManager->getIdentity();
        //var_dump($id,$field,$order);  
        return new ViewModel([
           'documents' => $paginator,
           'documentManager' => $this->documentsManager,
           'auth'=>$auth,
           'id'=>$id,
           'field'=>$field,
           'order'=>$order,
        ]);
    } 
    
    /**
     * This action displays a page allowing to add a new document.
     */
    public function addAction()
    {
        // Create documents form
        $form = new DocumentsForm( $this->entityManager);
        
        // Check if documents has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            

            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                 
                // Add document.
                $documents = $this->documentsManager->addDocuments($data);
  
                // Redirect to "view" page
                return $this->redirect()->toRoute('documents', 
                        ['action'=>'index', 'id'=>$documents->getId()]);                
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
    
    /**
     * The "view" action displays a page allowing to view document's details.
     */
    public function viewAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find a document with such ID.
        $documents = $this->entityManager->getRepository(Documents::class)
                ->find($id);
      
        
        if ($documents == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'documents' => $documents
        ]);
    }
    
    /**
     * The "edit" action displays a page allowing to edit document.
     */
    public function editAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $documents = $this->entityManager->getRepository(Documents::class)
                ->find($id);

        if (!$this->checkAuthorOfDocument($documents)) {
            $this->redirect()->toRoute('documents', ['action'=>'index']);
            
        }
        
        if ($documents == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Create user form
        $form = new DocumentsForm( $this->entityManager, $documents);
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                // Update the user.
                $this->documentsManager->updateDocuments($documents, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('documents', 
                        ['action'=>'view', 'id'=>$documents->getId()]);                
            }               
        } else {
            $form->setData(array(
                    'name'=>$documents->getName(),
                    'number'=>$documents->getNumber(),
                    'depart_issue'=>$documents->getDepartIssue(), 
                    'date_issue'=>$documents->getDateIssue(),
                ));
        }
        
        return new ViewModel(array(
            'documents' => $documents,
            'form' => $form
        ));
    }
    public function deleteAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $documents = $this->entityManager->getRepository(Documents::class)
                ->find($id);
        
        if ($documents == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
       if (!$this->checkAuthorOfDocument($documents)) {
            $this->redirect()->toRoute('documents', ['action'=>'index']);
           
        }
       else
       {
          
        $this->entityManager->remove($documents);
        
        $this->entityManager->flush();
       }

       $this->redirect()->toRoute('documents', ['action'=>'index']);
    }
    public function checkAuthorOfDocument($documents){
        $author=$documents->getAuthor();
        $auth_user=$this->authManager->getIdentity();
        //проверка на автора документа
      
        if ($author != $auth_user) {
            return false;            
        }
            return true;
    }
}


