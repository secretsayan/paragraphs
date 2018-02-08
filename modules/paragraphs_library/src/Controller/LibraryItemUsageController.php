<?php

namespace Drupal\paragraphs_library\Controller;

use Drupal\entity_usage\Controller\ListUsageController;
use Drupal\paragraphs_library\Entity\LibraryItem;

class LibraryItemUsageController extends ListUsageController {

  /**
   * Shows usage of library item.
   *
   * @param \Drupal\paragraphs_library\Entity\LibraryItem $paragraphs_library_item
   *   A library item object.
   *
   * @return array
   *   An array as expected by drupal_render()
   */
  public function showUsagePage($paragraphs_library_item) {
    return parent::listUsagePage('paragraphs_library_item', $paragraphs_library_item);
  }

  /**
   * Page title callback for library item usage
   *
   * @param \Drupal\paragraphs_library\Entity\LibraryItem $paragraphs_library_item
   *   A library item object.
   *
   * @return string
   *   The page title.
   */
  public function showTitle($paragraphs_library_item) {
    return parent::getTitle('paragraphs_library_item', $paragraphs_library_item);
  }
}
