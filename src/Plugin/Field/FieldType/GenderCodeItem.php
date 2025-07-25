<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'gender_code' field type.
 */
#[FieldType(
  id: "gender_code",
  module: "ewp_core",
  label: new TranslatableMarkup("Gender code"),
  description: [
    new TranslatableMarkup("Values stored are predefined integer values."),
    new TranslatableMarkup("For example, 9 => 'Not applicable'."),
    new TranslatableMarkup("See ISO/IEC 5218:2004."),
  ],
  category: "ewp_selection_list",
  default_widget: "gender_code_default",
  default_formatter: "gender_code_default",
)]
class GenderCodeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('Gender code'))
      ->addConstraint('Choice', ['0', '1', '2', '9']);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'int',
          'unsigned' => TRUE,
          'size' => 'tiny',
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
