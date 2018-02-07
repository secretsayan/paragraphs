<?php

namespace Drupal\paragraphs\Plugin\migrate\source\d7;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Field_collection_type source.
 *
 * @MigrateSource(
 *   id = "d7_field_collection_type",
 *   source_module = "field_collection"
 * )
 */
class FieldCollectionType extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('field_config', 'fc')
      ->fields('fc');
    $query->condition('fc.type', 'field_collection');
    $query->condition('fc.active', TRUE);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {

    $name = $row->getSourceProperty('field_name');

    if ($this->configuration['addDescription']) {
      $row->setSourceProperty('description', 'Migrated from field_collection ' . $name);
    }
    else {
      $row->setSourceProperty('description', '');
    }

    // Remove prefix if it is set in configs.
    $prefix = $this->configuration['prefix'];
    if (isset($prefix) && strpos($name, $prefix) === 0) {
      $name = substr($name, strlen($prefix));
    }
    $row->setSourceProperty('bundle', $name);
    // Set label from bundle because we don't have a label in D7 field
    // collections.
    $row->setSourceProperty('name', ucfirst(preg_replace('/_/', ' ', $name)));

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'bundle' => $this->t('Paragraph type machine name'),
      'name' => $this->t('Paragraph type label'),
      'description' => $this->t('Paragraph type description'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['id']['type'] = 'integer';
    return $ids;
  }

}
