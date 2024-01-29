<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'eqf_level' field type.
 *
 * @FieldType(
 *   id = "eqf_level",
 *   label = @Translation("EQF level"),
 *   description = {
 *     @Translation("Values stored are predefined integer values"),
 *     @Translation("For example, 6 => 'EQF-6 (Bachelor)'"),
 *     @Translation("see European Qualifications Framework"),
 *   },
 *   category = "ewp_selection_list",
 *   default_widget = "eqf_level_default",
 *   default_formatter = "eqf_level_default",
 * )
 */
class EqfLevelItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('EQF level'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'char',
          'length' => 255,
          'not null' => FALSE,
        ],
      ],
      'indexes' => [
        'value' => ['value'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

}
