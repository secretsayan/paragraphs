<?php

namespace Drupal\paragraphs\Plugin\migrate\source\d7;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Paragraphs source.
 *
 * @MigrateSource(
 *   id = "d7_paragraphs_type",
 *   source_module = "paragraphs"
 * )
 */
class ParagraphType extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('paragraphs_bundle', 'pb')
      ->fields('pb');

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {

    if ($this->configuration['addDescription']) {
      $name = $row->getSourceProperty('name');
      $row->setSourceProperty('description', 'Migrated from paragraph bundle ' . $name);
    }
    else {
      $row->setSourceProperty('description', '');
    }

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
    $ids['bundle']['type'] = 'string';
    return $ids;
  }

}
