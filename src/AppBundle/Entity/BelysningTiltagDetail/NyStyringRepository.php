<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity\BelysningTiltagDetail;

use Doctrine\ORM\EntityRepository;

/**
 * BelysningTiltagRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NyStyringRepository extends EntityRepository {

  public function findNotDeleted() {

    $query = $this->_em->createQuery("SELECT ns FROM AppBundle:BelysningTiltagDetail\NyStyring ns WHERE ns.deletedAt IS NULL");

    return $query->getResult();

  }

}