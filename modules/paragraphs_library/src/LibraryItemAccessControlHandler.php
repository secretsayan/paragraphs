<?php

namespace Drupal\paragraphs_library;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\Entity;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access control handler for the paragraphs_library_item entity type.
 *
 * @see \Drupal\paragraphs_library\Entity\LibraryItem
 */
class LibraryItemAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $library_item, $operation, AccountInterface $account) {
    if ($operation == 'delete') {
      $usage_data = \Drupal::service('entity_usage.usage')->listUsage($library_item);
      if ($usage_data) {
        return AccessResult::forbidden();
      }
    }

    /** @var \Drupal\paragraphs\Entity\Paragraph $paragraph */
    if ($referenced_paragraph = $library_item->paragraphs->entity) {
      // Forward the access check to the referenced paragraph.
      return $referenced_paragraph->access($operation, $account, TRUE);
    }
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  public function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'create paragraph library item')->orIf(parent::checkCreateAccess($account, $context, $entity_bundle));
  }

}
