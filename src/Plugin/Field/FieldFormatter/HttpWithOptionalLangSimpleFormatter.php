<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_http_lang_simple' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_http_lang_simple",
 *   label = @Translation("Simple (plain text only)"),
 *   field_types = {
 *     "ewp_http_lang"
 *   }
 * )
 */
class HttpWithOptionalLangSimpleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $item->uri];
    }

    return $elements;
  }

}
