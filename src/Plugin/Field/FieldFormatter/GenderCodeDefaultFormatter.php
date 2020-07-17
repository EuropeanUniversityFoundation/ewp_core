<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'gender_code_default' formatter.
 *
 * @FieldFormatter(
 *   id = "gender_code_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "gender_code"
 *   }
 * )
 */
class GenderCodeDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $gender_codes = \ewp_core_get_eqf_levels();
    // Already a flat array
    // $options = OptGroup::flattenOptions($gender_codes);
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      // $elements[$delta] = ['#markup' => $options[$value]];
      $elements[$delta] = ['#markup' => $gender_codes[$value]];
    }
    return $elements;
  }

}
