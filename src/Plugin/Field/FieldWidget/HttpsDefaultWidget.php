<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_https_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_https_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_https"
 *   }
 * )
 */
class HttpsDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['uri'] = [
      '#type' => 'url',
      '#default_value' => $items[$delta]->uri ?? NULL,
      '#maxlength' => 2048,
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    $cardinality = $this->fieldDefinition
      ->getFieldStorageDefinition()
      ->getCardinality();

    if ($cardinality === 1) {
      $element['uri']['#title'] = $element['#title'];
    }

    return $element;
  }

}
