<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

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
    $gender_codes = \Drupal::service('ewp_core.gender')->getOptions();
    $elements = [];
    foreach ($items as $delta => $item) {
      $value = $item->value;
      $elements[$delta] = [
        '#theme' => 'ewp_gender_code_default',
        '#value' => $gender_codes[$value],
      ];
    }
    return $elements;
  }

}
