<?php
namespace AppBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\TiltagDetail;

class TiltagListener {
  private static $rapportFieldsThatTriggerRecalculationOfTiltag = [ 'faktorPaaVarmebesparelse' ];

  /**
   * Recalculate Tiltag when it is updated or when any related TiltagDetail is updated
   * @param OnFlushEventArgs $args
   */
  public function onFlush(OnFlushEventArgs $args) {
    $em = $args->getEntityManager();
    $uow = $em->getUnitOfWork();

    $entities = array_merge(
      $uow->getScheduledEntityInsertions(),
      $uow->getScheduledEntityUpdates()
    );

    $targets = array();

    foreach ($entities as $entity) {
      if ($entity instanceof Tiltag) {
        $targets[] = $entity;
        $targets[] = $entity->getRapport();;
      }
      elseif ($entity instanceof TiltagDetail) {
        $targets[] = $entity;
        $targets[] = $entity->getTiltag();
        $targets[] = $entity->getTiltag()->getRapport();
      }
      elseif ($entity instanceof Rapport) {
        $changeSet = $uow->getEntityChangeSet($entity);
        // Add each Tiltag from Rapport that has changes in select values.
        foreach (self::$rapportFieldsThatTriggerRecalculationOfTiltag as $field) {
          if (isset($changeSet[$field]) && $changeSet[$field][0] != $changeSet[$field][1]) {
            foreach ($entity->getTiltag() as $tiltag) {
              $targets[] = $tiltag;
            }
            break;
          }
        }
      }
    }

    foreach ($targets as $target) {
      $target->calculate();
      $em->persist($target);
      $md = $em->getClassMetadata(get_class($target));
      $uow->recomputeSingleEntityChangeSet($md, $target);
    }
  }
}
