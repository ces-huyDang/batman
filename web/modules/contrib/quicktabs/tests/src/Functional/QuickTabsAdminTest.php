<?php

namespace Drupal\Tests\quicktabs\Functional;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests creating and saving a QuickTabs instance.
 *
 * @group quicktabs
 */
class QuickTabsAdminTest extends BrowserTestBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'node',
    'block',
    'menu_ui',
    'user',
    'taxonomy',
    'toolbar',
    'quicktabs',
    'views',
  ];

  /**
   * A user with permission to access the administrative toolbar.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $perms = [
      'access toolbar',
      'access administration pages',
      'administer site configuration',
      'bypass node access',
      'administer themes',
      'administer nodes',
      'access content overview',
      'administer blocks',
      'administer menu',
      'administer modules',
      'administer permissions',
      'administer users',
      'access user profiles',
      'administer taxonomy',
      'administer quicktabs',
    ];

    // Create an administrative user and log it in.
    $this->adminUser = $this->drupalCreateUser($perms);

    $this->drupalLogin($this->adminUser);

    // Create an article content type.
    $this->drupalCreateContentType([
      'type' => 'article',
    ]);
  }

  /**
   * Test all vocabularies appear on admin page.
   */
  public function testQuickTabsAdmin() {
    $this->drupalGet('admin/structure/quicktabs');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->responseContains('Quick Tabs');
    $this->drupalGet('admin/structure/quicktabs/add');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->responseContains('Add QuickTabs Instance');
    $this->assertSession()->responseContains('Name');
    $this->assertSession()->responseContains('Renderer');
    $this->assertSession()->responseContains('Default tab');
    $this->assertSession()->responseContains('Hide empty tabs');
    $this->assertSession()->responseContains('Add tab');
    $this->assertSession()->responseContains('Save');

    $node1 = $this->drupalCreateNode([
      'title' => $this->t('Node 1'),
      'type' => 'article',
    ]);
    $node2 = $this->drupalCreateNode([
      'title' => $this->t('Node 2'),
      'type' => 'article',
    ]);

    $edit = [
      'label' => $this->randomMachineName(),
      'id' => strtolower($this->randomMachineName()),
      'renderer' => 'quick_tabs',
      'options[quick_tabs][ajax]' => 0,
      'hide_empty_tabs' => 1,
      'default_tab' => 9999,
      'configuration_data[0][title]' => $this->randomMachineName(),
      'configuration_data[0][type]' => 'node_content',
      'configuration_data[0][content][node_content][options][nid]' => $node1->id(),
      'configuration_data[0][content][node_content][options][view_mode]' => 'full',
      'configuration_data[0][content][node_content][options][hide_title]' => 1,
      'configuration_data[1][title]' => $this->randomMachineName(),
      'configuration_data[1][type]' => 'node_content',
      'configuration_data[1][content][node_content][options][nid]' => $node2->id(),
      'configuration_data[1][content][node_content][options][view_mode]' => 'full',
      'configuration_data[1][content][node_content][options][hide_title]' => 1,
    ];
    $this->drupalGet('admin/structure/quicktabs/add');

    $this->submitForm($edit, $this->t('Save'));

    $qt = \Drupal::service('entity_type.manager')->getStorage('quicktabs_instance')->load($edit['id']);

    $this->assertEquals('Drupal\quicktabs\Entity\QuickTabsInstance', get_class($qt));
    $this->assertEquals($qt->id(), $edit['id']);
    $this->assertEquals($qt->label(), $edit['label']);
    $this->assertEquals($qt->getRenderer(), $edit['renderer']);
    $this->assertEquals($qt->getHideEmptyTabs(), $edit['hide_empty_tabs']);
    $this->assertEquals($qt->getDefaultTab(), $edit['default_tab']);

    $configurationData = $qt->getConfigurationData();
    $this->assertEquals($configurationData[0]['title'], $edit['configuration_data[0][title]']);
    $this->assertEquals($configurationData[1]['title'], $edit['configuration_data[1][title]']);
    $this->assertEquals($configurationData[0]['type'], $edit['configuration_data[0][type]']);
    $this->assertEquals($configurationData[1]['type'], $edit['configuration_data[1][type]']);
    $this->assertEquals($configurationData[0]['content']['node_content']['options']['nid'], $edit['configuration_data[0][content][node_content][options][nid]']);
    $this->assertEquals($configurationData[1]['content']['node_content']['options']['nid'], $edit['configuration_data[1][content][node_content][options][nid]']);
    $this->assertEquals($configurationData[0]['content']['node_content']['options']['view_mode'], $edit['configuration_data[0][content][node_content][options][view_mode]']);
    $this->assertEquals($configurationData[1]['content']['node_content']['options']['view_mode'], $edit['configuration_data[1][content][node_content][options][view_mode]']);
    $this->assertEquals($configurationData[0]['content']['node_content']['options']['hide_title'], $edit['configuration_data[0][content][node_content][options][hide_title]']);
    $this->assertEquals($configurationData[1]['content']['node_content']['options']['hide_title'], $edit['configuration_data[1][content][node_content][options][hide_title]']);
    $this->drupalGet('admin/structure/quicktabs/' . $qt->id() . '/delete');

    $this->submitForm([], $this->t('Delete'));

    $qt = \Drupal::service('entity_type.manager')->getStorage('quicktabs_instance')->load($edit['id']);
    $this->assertNull($qt, $this->t('QuickTabs instance not found in database'));
  }

}
