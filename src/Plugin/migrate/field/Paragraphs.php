<?php

namespace Drupal\paragraphs\Plugin\migrate\field;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_drupal\Plugin\migrate\field\FieldPluginBase;

/**
 * Field Plugin for paragraphs migrations.
 *
 * @todo Implement ::processFieldValues()
 * @see https://www.drupal.org/project/paragraphs/issues/2911244
 *
 * @MigrateField(
 *   id = "paragraphs",
 *   core = {7},
 *   type_map = {
 *     "paragraphs" = "entity_reference_revisions",
 *   },
 *   source_module = "paragraphs",
 *   destination_module = "paragraphs",
 * )
 */
class Paragraphs extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function processFieldWidget(MigrationInterface $migration) {
    parent::processFieldWidget($migration);
    $title = [
      'paragraphs' => [
        'plugin' => 'paragraphs_process_on_value',
        'source_value' => 'type',
        'expected_value' => 'paragraphs',
        'process' => [
          'plugin' => 'get',
          'source' => 'settings/title',
        ],
      ],
    ];
    $title_plural = [
      'paragraphs' => [
        'plugin' => 'paragraphs_process_on_value',
        'source_value' => 'type',
        'expected_value' => 'paragraphs',
        'process' => [
          'plugin' => 'get',
          'source' => 'settings/title_multiple',
        ],
      ],
    ];
    $edit_mode = [
      'paragraphs' => [
        'plugin' => 'paragraphs_process_on_value',
        'source_value' => 'type',
        'expected_value' => 'paragraphs',
        'process' => [
          'plugin' => 'get',
          'source' => 'settings/default_edit_mode',
        ],
      ],
    ];
    $add_mode = [
      'paragraphs' => [
        'plugin' => 'paragraphs_process_on_value',
        'source_value' => 'type',
        'expected_value' => 'paragraphs',
        'process' => [
          'plugin' => 'get',
          'source' => 'settings/add_mode',
        ],
      ],
    ];

    $migration->mergeProcessOfProperty('options/settings/title', $title);
    $migration->mergeProcessOfProperty('options/settings/title_plural', $title_plural);
    $migration->mergeProcessOfProperty('options/settings/edit_mode', $edit_mode);
    $migration->mergeProcessOfProperty('options/settings/add_mode', $add_mode);
  }

  /**
   * {@inheritdoc}
   */
  public function processFieldFormatter(MigrationInterface $migration) {
    $options_type[0]['map']['paragraphs_view'] = 'entity_reference_revisions_entity_view';
    $view_mode = [
      'paragraphs' => [
        'plugin' => 'paragraphs_process_on_value',
        'source_value' => 'type',
        'expected_value' => 'paragraphs',
        'process' => [
          'plugin' => 'get',
          'source' => 'formatter/settings/view_mode',
        ],
      ],
    ];
    $migration->mergeProcessOfProperty('options/type', $options_type);
    $migration->mergeProcessOfProperty('options/settings/view_mode', $view_mode);
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldWidgetMap() {
    return ['paragraphs_embed' => 'entity_reference_paragraphs']
      + parent::getFieldWidgetMap();
  }

  /**
   * {@inheritdoc}
   */
  public function processField(MigrationInterface $migration) {

    $settings = [
      'paragraphs' => [
        'plugin' => 'paragraphs_field_settings',
      ],
    ];
    $migration->mergeProcessOfProperty('settings', $settings);
  }

  /**
   * {@inheritdoc}
   */
  public function processFieldInstance(MigrationInterface $migration) {

    $settings = [
      'paragraphs' => [
        'plugin' => 'paragraphs_field_instance_settings',
      ],
    ];
    $migration->mergeProcessOfProperty('settings', $settings);
  }

}
