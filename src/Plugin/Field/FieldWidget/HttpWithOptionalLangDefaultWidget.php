<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_http_lang_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_http_lang_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_http_lang"
 *   }
 * )
 */
class HttpWithOptionalLangDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      //
    ] + parent::defaultSettings();
  }

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
      '#default_value' => isset($items[$delta]->uri) ? $items[$delta]->uri : NULL,
      '#maxlength' => 2048,
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    if ($this->fieldDefinition->getFieldStorageDefinition()->getCardinality() == 1) {
      $element['uri']['#title'] = $element['#title'];
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
