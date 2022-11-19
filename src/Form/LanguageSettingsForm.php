<?php

namespace Drupal\ewp_core\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure EWP core language typed field settings.
 */
class LanguageSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ewp_core_language_settings';
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
    $config = $this->config('ewp_core.settings');

    $list_description = '<p>' . $this
      ->t('Enter one code & language pair per line, in the format %format.', [
        '%format' => 'code|Language name'
      ]);
    $list_description .= '<br/>' . $this
      ->t('If no name is provided, the code will also be used as the label.');
    $list_description .= '</p>';

    $form['lang_primary'] = [
      '#title' => $this->t('Primary language settings'),
      '#type' => 'details',
      '#open' => TRUE,
      '#tree' => FALSE,
    ];

    $form['lang_primary']['lang_primary_group_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Primary language group label'),
      '#default_value' => $config->get('lang_primary_group_label') ?? NULL,
    ];

    $lang_primary_list = $config->get('lang_primary_list');
    $lang_primary_text = ($lang_primary_list)
      ? implode("\n", $lang_primary_list)
      : '';

    $form['lang_primary']['lang_primary_list'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Primary language list'),
      '#description' => $list_description,
      '#default_value' => $lang_primary_text,
      '#rows' => 5,
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
      '#default_value' => $config->get('lang_secondary_group_label') ?? NULL,
    ];

    $lang_secondary_list = $config->get('lang_secondary_list');
    $lang_secondary_text = ($lang_secondary_list)
      ? implode("\n", $lang_secondary_list)
      : '';

    $form['lang_secondary']['lang_secondary_list'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Secondary language list'),
      '#description' => $list_description,
      '#default_value' => $lang_secondary_text,
      '#rows' => 5,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $lang_primary_label = $form_state->getValue('lang_primary_group_label');
    $lang_primary_text = $form_state->getValue('lang_primary_list');
    $lang_primary_list = array_filter(
      array_map(
        'trim', explode(
          "\n", $lang_primary_text
        )
      ), 'strlen'
    );

    $lang_secondary_label = $form_state->getValue('lang_secondary_group_label');
    $lang_secondary_text = $form_state->getValue('lang_secondary_list');
    $lang_secondary_list = array_filter(
      array_map(
        'trim', explode(
          "\n", $lang_secondary_text
        )
      ), 'strlen'
    );

    $this->config('ewp_core.settings')
      ->set('lang_primary_group_label', $lang_primary_label)
      ->set('lang_primary_list', $lang_primary_list)
      ->set('lang_secondary_group_label', $lang_secondary_label)
      ->set('lang_secondary_list', $lang_secondary_list)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
