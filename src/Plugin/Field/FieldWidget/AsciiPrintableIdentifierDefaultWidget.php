<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ascii_identifier_default' widget.
 *
 * @FieldWidget(
 *   id = "ascii_identifier_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ascii_identifier"
 *   }
 * )
 */
class AsciiPrintableIdentifierDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'size' => 64,
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
      '#title' => $this->t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];

    $elements['placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('Textfield size: @size', [
      '@size' => $this->getSetting('size'),
    ]);

    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = $this->t('Placeholder: @placeholder', [
        '@placeholder' => $this->getSetting('placeholder'),
      ]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'textfield',
      '#default_value' => $items[$delta]->value ?? NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#maxlength' => $this->getFieldSetting('max_length'),
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    $cardinality = $this->fieldDefinition
      ->getFieldStorageDefinition()
      ->getCardinality();

    if ($cardinality === 1) {
      $element['value']['#title'] = $element['#title'];
    }

    $element['value']['#attributes']['class'][] = 'ascii-widget';
    $element['#attached']['library'][] = 'ewp_core/ascii_id';

    return $element;
  }

}
