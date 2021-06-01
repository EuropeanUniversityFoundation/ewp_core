<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'cefr_level_default' formatter.
 *
 * @FieldFormatter(
 *   id = "cefr_level_default",
 *   label = @Translation("Default (with parent category)"),
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
    $cefr_levels = \Drupal::service('ewp_core.cefr')->getOptions();
    $options = OptGroup::flattenOptions($cefr_levels);
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      # fetch the parent
      $parent = NULL;
      foreach ($cefr_levels as $key => $array) {
        if (array_key_exists($value, $array)) {
          $parent = $key;
        }
      }
      $elements[$delta] = [
        '#theme' => 'ewp_cefr_level_default',
        '#value' => $options[$value],
        '#parent' => $parent,
      ];
    }
    return $elements;
  }

}
