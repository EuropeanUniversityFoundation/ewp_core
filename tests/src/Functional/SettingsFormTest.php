<?php

namespace Drupal\Tests\ewp_core\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the language settings form.
 *
 * @group ewp_core
 */
class SettingsFormTest extends BrowserTestBase {

  const CONFIG_KEY = 'ewp_core.settings';
  const FORM_PATH = 'admin/ewp/settings/lang';
  const PERMISSION = 'administer ewp lang settings';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['user', 'ewp_core'];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
  }

  /**
   * Tests access to the settings form by a non-privileged user.
   */
  public function testSettingsFormWithoutPermission() {
    $account = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($account);

    $this->drupalGet(self::FORM_PATH);
    $this->assertSession()
      ->statusCodeEquals(403);
  }

  /**
   * Tests the settings form as a privileged user.
   */
  public function testSettingsForm() {
    $account = $this->drupalCreateUser([self::PERMISSION]);
    $this->drupalLogin($account);

    // Test the default configuration.
    $default_config = $this->config(self::CONFIG_KEY);

    $lang_primary_group_label = $default_config->get('lang_primary_group_label');
    $this->assertEquals('EU official languages', $lang_primary_group_label);

    $lang_primary_list = $default_config->get('lang_primary_list');
    $this->assertContains('el|Greek', $lang_primary_list);

    $lang_secondary_group_label = $default_config->get('lang_secondary_group_label');
    $this->assertEquals('Other languages', $lang_secondary_group_label);

    $lang_secondary_list = $default_config->get('lang_secondary_list');
    $this->assertContains('tr|Turkish', $lang_secondary_list);

    // Test access to the settings form.
    $this->drupalGet(self::FORM_PATH);
    $this->assertSession()
      ->statusCodeEquals(200);

    // Test default values on the page.
    $this->assertSession()
      ->pageTextMatchesCount(2, '/Greek/');
    $this->assertSession()
      ->pageTextMatchesCount(1, '/Turkish/');

    // Test form submission.
    $submission_data = [
      'lang_primary_group_label' => 'European',
      'lang_primary_list' => implode("\n", [
        'pt-PT|Portuguese (Portugal)',
        'es-ES|Spanish (Spain)',
      ]),
      'lang_secondary_group_label' => 'South American',
      'lang_secondary_list' => implode("\n", [
        'pt-BR|Portuguese (Brazil)',
        'es-AR|Spanish (Argentina)',
      ]),
    ];
    $this->submitForm($submission_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('The configuration options have been saved.');

    // Test the configuration has been updated.
    $new_config = $this->config(self::CONFIG_KEY);

    $lang_primary_group_label = $new_config->get('lang_primary_group_label');
    $this->assertEquals('European', $lang_primary_group_label);

    $lang_primary_list = $new_config->get('lang_primary_list');
    $this->assertContains('pt-PT|Portuguese (Portugal)', $lang_primary_list);
    $this->assertNotContains('el|Greek', $lang_primary_list);

    $lang_secondary_group_label = $new_config->get('lang_secondary_group_label');
    $this->assertEquals('South American', $lang_secondary_group_label);

    $lang_secondary_list = $new_config->get('lang_secondary_list');
    $this->assertContains('pt-BR|Portuguese (Brazil)', $lang_secondary_list);
    $this->assertNotContains('tr|Turkish', $lang_secondary_list);

    // Test the form loads normally.
    $this->drupalGet(self::FORM_PATH);
    $this->assertSession()
      ->statusCodeEquals(200);

    // Test new values on the page.
    $this->assertSession()
      ->pageTextMatchesCount(2, '/Portuguese/');
    $this->assertSession()
      ->pageTextMatchesCount(2, '/Spanish/');

  }

}
