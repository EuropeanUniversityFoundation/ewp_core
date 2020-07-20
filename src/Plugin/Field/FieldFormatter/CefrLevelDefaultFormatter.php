<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'cefr_level_default' formatter.
 *
 * @FieldFormatter(
 *   id = "cefr_level_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "cefr_level"
 *   }
 * )
 */
class CefrLevelDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $cefr_levels = \ewp_core_get_cefr_levels();
    // Already a flat array
    // $options = OptGroup::flattenOptions($eqf_levels);
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      // $elements[$delta] = ['#markup' => $options[$value]];
      $elements[$delta] = ['#markup' => $cefr_levels[$value]];
    }
    return $elements;
  }

}
