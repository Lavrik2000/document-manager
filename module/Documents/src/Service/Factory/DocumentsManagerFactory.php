<?php
namespace Documents\Service\Factory;

use Interop\Container\ContainerInterface;
use Documents\Service\DocumentsManager;

/**
 * This is the factory class for Documents Manager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class DocumentsManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authenticationService = $container->get(\Zend\Authentication\AuthenticationService::class);
        return new DocumentsManager($entityManager,$authenticationService);
    }
}
