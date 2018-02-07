<?php

namespace Drupal\Tests\paragraphs\Kernel;

use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\Tests\migrate_drupal\Kernel\MigrateDrupalTestBase;

/**
 * Tests Paragraph and Field Collection Migrations.
 *
 * @group paragraphs
 */
class ParagraphsMigrationTest extends MigrateDrupalTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['paragraphs', 'user', 'system', 'field'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->loadFixture(__DIR__ . '/../../fixtures/drupal7.php');

    $this->executeMigration('d7_field_collection_type');
    $this->executeMigration('d7_paragraphs_type');
  }

  /**
   * Check to see if paragraph types were created.
   *
   * @param string $bundle_machine_name
   *   The bundle to test for.
   * @param string $bundle_label
   *   The bundle's label.
   */
  protected function assertParagraphBundleExists($bundle_machine_name, $bundle_label) {
    $bundle = ParagraphsType::load($bundle_machine_name);
    $this->assertInstanceOf(ParagraphsType::class, $bundle);
    $this->assertEquals($bundle_label, $bundle->label());
  }

  /**
   * Test if the field collection type was brought over as a paragraph.
   */
  public function testFieldCollectionTypeMigration() {
    $this->assertParagraphBundleExists('field_collection_test', 'Field collection test');
  }

  /**
   * Test if the paragraph type was brought over as a paragraph.
   */
  public function testParagraphsTypeMigration() {
    $this->assertParagraphBundleExists('paragraph_bundle_test', 'Paragraph Bundle Test');
  }

}
