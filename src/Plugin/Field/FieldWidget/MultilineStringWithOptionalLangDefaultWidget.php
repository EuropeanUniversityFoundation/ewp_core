<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_multiline_lang_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_multiline_lang_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_multiline_lang"
 *   }
 * )
 */
class MultilineStringWithOptionalLangDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'rows' => '5',
      'placeholder' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['rows'] = [
      '#type' => 'number',
      '#title' => t('Rows'),
      '#default_value' => $this->getSetting('rows'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Number of rows: @rows', ['@rows' => $this->getSetting('rows')]);
    $placeholder = $this->getSetting('placeholder');
    if (!empty($placeholder)) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $placeholder]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = $element + [
      '#type' => 'container',
      '#attributes' => ['class' => ['inline-widget']],
    ];
    $element['#attached']['library'][] = 'ewp_core/inline_widget';

    $element['multiline'] = [
      '#type' => 'textarea',
      '#default_value' => isset($items[$delta]->multiline) ? $items[$delta]->multiline : NULL,
      '#rows' => $this->getSetting('rows'),
      '#placeholder' => $this->getSetting('placeholder'),
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    if ($this->fieldDefinition->getFieldStorageDefinition()->getCardinality() == 1) {
      $element['multiline']['#title'] = $element['#title'];
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
