<?php
namespace Documents\Repository;

use Doctrine\ORM\EntityRepository;
use Documents\Entity\Documents;

/**
 * This is the custom repository class for Post entity.
 */
class DocumentsRepository extends EntityRepository
{
    /**
     * Retrieves all published posts in descending date order.
     * @return Query
     */
    public function findDocuments($field,$order)
    {
        $entityManager = $this->getEntityManager();
        
        $queryBuilder = $entityManager->createQueryBuilder();
        
        $queryBuilder->select('d')
            ->from(Documents::class,'d')
            ->orderBy("d.".$field, $order);
        
        
        return $queryBuilder->getQuery();
    }
    
      
}