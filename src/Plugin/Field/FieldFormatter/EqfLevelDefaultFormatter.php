<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'eqf_level_default' formatter.
 *
 * @FieldFormatter(
 *   id = "eqf_level_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "eqf_level"
 *   }
 * )
 */
class EqfLevelDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $eqf_levels = \Drupal::service('ewp_core.eqf')->getOptions();
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      $elements[$delta] = [
        '#theme' => 'ewp_eqf_level_default',
        '#value' => $eqf_levels[$value],
      ];
    }
    return $elements;
  }

}
