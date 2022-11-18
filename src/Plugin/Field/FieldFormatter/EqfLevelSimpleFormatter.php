<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'eqf_level_simple' formatter.
 *
 * @FieldFormatter(
 *   id = "eqf_level_simple",
 *   label = @Translation("Simple (number only)"),
 *   field_types = {
 *     "eqf_level"
 *   }
 * )
 */
class EqfLevelSimpleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      // Print only the key which is the EQF level number.
      $elements[$delta] = ['#markup' => $item->value];
    }

    return $elements;
  }

}
