<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TiltagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TiltagRepository extends EntityRepository {
  /**
   * Create a new Tiltag based on type
   *
   * @param string $type
   * @return Tiltag
   */
  public function create($type) {
    $className = '\\AppBundle\\Entity\\'.ucwords($type).'Tiltag';

    if (!class_exists($className)) {
        throw new \InvalidArgumentException('Unknown tiltag type: '.$type);
    }

    return new $className();
  }
}
