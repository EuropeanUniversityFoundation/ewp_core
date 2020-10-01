<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'cefr_level_simple' formatter.
 *
 * @FieldFormatter(
 *   id = "cefr_level_simple",
 *   label = @Translation("Simple (plain text)"),
 *   field_types = {
 *     "cefr_level"
 *   }
 * )
 */
class CefrLevelSimpleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $cefr_levels = \ewp_core_get_cefr_levels();
    $options = OptGroup::flattenOptions($cefr_levels);
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      $elements[$delta] = ['#markup' => $options[$value]];
    }
    return $elements;
  }

}
