<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'gender_code_simple' formatter.
 */
#[FieldFormatter(
  id: 'gender_code_simple',
  label: new TranslatableMarkup('Simple (code only)'),
  field_types: [
    'gender_code',
  ],
)]
class GenderCodeSimpleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      // Print only the key which is the Gender code.
      $elements[$delta] = ['#markup' => $item->value];
    }

    return $elements;
  }

}
