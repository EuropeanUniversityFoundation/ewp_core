<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'cefr_level' field type.
 */
#[FieldType(
  id: "cefr_level",
  module: "ewp_core",
  label: new TranslatableMarkup("CEFR level"),
  description: [
    new TranslatableMarkup("DEPRECATED: use the CEFRL module instead."),
    new TranslatableMarkup("Values stored are predefined text values."),
    new TranslatableMarkup("For example, 'A1' => 'A1'."),
    new TranslatableMarkup("See Common European Reference Framework for Languages."),
  ],
  category: "ewp_selection_list",
  default_widget: "cefr_level_default",
  default_formatter: "cefr_level_default",
)]
class CefrLevelItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('CEFR level'));

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
