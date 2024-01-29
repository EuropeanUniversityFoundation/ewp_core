<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'gender_code' field type.
 *
 * @FieldType(
 *   id = "gender_code",
 *   label = @Translation("Gender code"),
 *   description = {
 *     @Translation("Values stored are predefined integer values"),
 *     @Translation("For example, 9 => 'Not applicable'"),
 *     @Translation("see ISO/IEC 5218:2004"),
 *   },
 *   category = "ewp_selection_list",
 *   default_widget = "gender_code_default",
 *   default_formatter = "gender_code_default",
 * )
 */
class GenderCodeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Gender code'));

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
