<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_string_lang_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_string_lang_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_string_lang"
 *   }
 * )
 */
class StringWithOptionalLangDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 60,
      'placeholder' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $elements['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: @size', ['@size' => $this->getSetting('size')]);
    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder')]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['string'] = [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->string) ? $items[$delta]->string : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    if ($this->fieldDefinition->getFieldStorageDefinition()->getCardinality() == 1) {
      $element['string']['#title'] = $element['#title'];
    }

    $element['lang'] = [
      '#type' => 'select',
      '#options' => \Drupal::service('ewp_core.langcode')->getOptions(),
      '#empty_option' => '- '.t('Language').' -',
      '#empty_value' => '',
      '#default_value' => isset($items[$delta]->lang) ? $items[$delta]->lang : NULL,
      '#description' => t('Optional'),
    ];

    return $element;
  }

}
