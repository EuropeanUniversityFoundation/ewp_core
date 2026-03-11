<?php

namespace Drupal\Tests\ewp_core\Functional;

use Drupal\user\Entity\User;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests the language settings form.
 *
 * @group ewp_core
 */
class LanguageTagSettingsFormTest extends BrowserTestBase {

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
   * Admin user account.
   */
  protected User $admin;

  /**
   * Authenticated user account.
   */
  protected User $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $this->user = $this->drupalCreateUser(['access content']);
    $this->admin = $this->drupalCreateUser([self::PERMISSION]);
  }

  /**
   * Tests access to the language tag settings form by a non-privileged user.
   */
  public function testLanguageTagSettingsFormWithoutPermission() {
    $this->drupalLogin($this->user);

    $this->drupalGet(self::FORM_PATH);
    $this->assertSession()
      ->statusCodeEquals(403);
  }

  /**
   * Tests the language tag settings form as a privileged user.
   */
  public function testLanguageTagSettingsForm() {
    $this->drupalLogin($this->admin);

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

    // Test access to the language tag settings form.
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

  /**
   * Tests incorrect inputs in the language tag settings form.
   */
  public function testLanguageTagSettingsFormErrors() {
    $this->drupalLogin($this->admin);

    $this->drupalGet(self::FORM_PATH);

    // Some correct data to begin with.
    $correct_data = [
      'lang_primary_group_label' => 'Primary',
      'lang_primary_list' => 'en|English',
      'lang_secondary_group_label' => 'Secondary',
      'lang_secondary_list' => 'und|undefined',
    ];
    $this->submitForm($correct_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('The configuration options have been saved.');

    // Test values cannot be empty.
    $bad_data = $correct_data;
    $bad_data['lang_primary_group_label'] = '';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('This value should not be blank.');

    $bad_data = $correct_data;
    $bad_data['lang_primary_list'] = '';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('This value should not be blank.');

    $bad_data = $correct_data;
    $bad_data['lang_secondary_group_label'] = '';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('This value should not be blank.');

    $bad_data = $correct_data;
    $bad_data['lang_secondary_list'] = '';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains('This value should not be blank.');

    // Test language tags must be valid.
    $bad_data = $correct_data;
    $bad_data['lang_primary_list'] = 'xyz';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains("'xyz' is not a valid language tag.");

    $bad_data = $correct_data;
    $bad_data['lang_secondary_list'] = 'pt-Madeira';
    $this->submitForm($bad_data, 'Save configuration');
    $this->assertSession()
      ->pageTextContains("'pt-Madeira' is not a valid language tag.");

  }

}
