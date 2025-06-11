<?php

namespace Drupal\ewp_core\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\ConfigTarget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ewp_core\LanguageTagManager;

/**
 * Configure EWP core language typed field settings.
 */
class LanguageTagSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ewp_core_language_tag_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ewp_core.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $help = '<p>';
    $help .= $this->t('Enter one @item per line, in the format %format.', [
      '@item' => 'language tag with optional label',
      '%format' => 'tag|Label',
    ]);
    $help .= '<br>';
    $help .= $this->t('If no label is provided, the tag will be the label.');
    $help .= '</p>';

    $form['lang_primary'] = [
      '#title' => $this->t('Primary language settings'),
      '#type' => 'details',
      '#open' => TRUE,
      '#tree' => FALSE,
    ];

    $form['lang_primary']['lang_primary_group_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Primary language group label'),
      '#config_target' => 'ewp_core.settings:lang_primary_group_label',
    ];

    $form['lang_primary']['lang_primary_list'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Primary language list'),
      '#description' => $help,
      '#rows' => 5,
      '#config_target' => new ConfigTarget(
        'ewp_core.settings',
        'lang_primary_list',
        static::class . '::arrayToMultiLineString',
        static::class . '::multiLineStringToArray',
      ),
    ];

    $form['lang_secondary'] = [
      '#title' => $this->t('Secondary language settings'),
      '#type' => 'details',
      '#open' => FALSE,
      '#tree' => FALSE,
    ];

    $form['lang_secondary']['lang_secondary_group_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secondary language group label'),
      '#config_target' => 'ewp_core.settings:lang_secondary_group_label',
    ];

    $form['lang_secondary']['lang_secondary_list'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Secondary language list'),
      '#description' => $help,
      '#rows' => 5,
      '#config_target' => new ConfigTarget(
        'ewp_core.settings',
        'lang_secondary_list',
        static::class . '::arrayToMultiLineString',
        static::class . '::multiLineStringToArray',
      ),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $lang_primary_text = $form_state->getValue('lang_primary_list');
    if (empty($lang_primary_text)) {
      $default = LanguageTagManager::DEFAULT_TAG_PRIMARY;
      $form_state->setValue('lang_primary_list', $default);
    }

    $lang_secondary_text = $form_state->getValue('lang_secondary_list');
    if (empty($lang_secondary_text)) {
      $default = LanguageTagManager::DEFAULT_TAG_SECONDARY;
      $form_state->setValue('lang_secondary_list', $default);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * Prepares the submitted value to be stored in config.
   *
   * @param string $value
   *   The submitted value.
   *
   * @return array
   *   The value to be stored in config.
   */
  public static function multiLineStringToArray(string $value): array {
    return array_filter(array_map('trim', explode("\n", trim($value))));
  }

  /**
   * Prepares the config value to be displayed in the form.
   *
   * @param array $value
   *   The value saved in config.
   *
   * @return string
   *   The value of the form element.
   */
  public static function arrayToMultiLineString(array $value): string {
    return implode("\n", $value);
  }

}
