<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'eqf_level_simple' formatter.
 *
 * @FieldFormatter(
 *   id = "eqf_level_simple",
 *   label = @Translation("Simple (plain text)"),
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
    $eqf_levels = \ewp_core_get_eqf_levels();
    // Already a flat array
    // $options = OptGroup::flattenOptions($eqf_levels);
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      // $elements[$delta] = ['#markup' => $options[$value]];
      $elements[$delta] = ['#markup' => $eqf_levels[$value]];
    }
    return $elements;
  }

}
