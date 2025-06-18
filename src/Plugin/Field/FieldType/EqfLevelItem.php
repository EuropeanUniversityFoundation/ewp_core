<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'eqf_level' field type.
 */
#[FieldType(
  id: "eqf_level",
  module: "ewp_core",
  label: new TranslatableMarkup("EQF level"),
  description: [
    new TranslatableMarkup("Values stored are predefined integer values."),
    new TranslatableMarkup("For example, 6 => 'EQF-6 (Bachelor)'."),
    new TranslatableMarkup("See European Qualifications Framework."),
  ],
  category: "ewp_selection_list",
  default_widget: "eqf_level_default",
  default_formatter: "eqf_level_default",
)]
class EqfLevelItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('EQF level'))
      ->addConstraint('Range', ['min' => '1', 'max' => '8']);

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
