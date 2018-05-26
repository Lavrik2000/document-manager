<?php
namespace Documents\Controller\Factory;

use Interop\Container\ContainerInterface;
use Documents\Controller\DocumentsController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Documents\Service\DocumentsManager;
    
/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class DocumentsControllerFactory implements FactoryInterface
{
   
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        $documentsManager = $container->get(DocumentsManager::class);
        $authManager =  $container->get(\Zend\Authentication\AuthenticationService::class);
        

        return new DocumentsController($entityManager,$documentsManager, $authManager);
    }
}
