<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_multiline_lang' field type.
 */
#[FieldType(
  id: "ewp_multiline_lang",
  module: "ewp_core",
  label: new TranslatableMarkup("Multiline string with optional lang"),
  description: [
    new TranslatableMarkup("Stores a long string."),
    new TranslatableMarkup("Stores an optional IETF BCP 47 language tag."),
    new TranslatableMarkup("e.g. el for Greek, el-Latn for Greek in Latin script."),
  ],
  category: "ewp_lang",
  default_widget: "ewp_multiline_lang_default",
  default_formatter: "ewp_multiline_lang_default",
)]
class MultilineStringWithOptionalLangItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['multiline'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Text value'))
      ->setRequired(TRUE);

    $properties['lang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Language tag'))
      ->addConstraint('ValidLanguageTag');

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'multiline' => [
          'type' => 'text',
          'size' => 'big',
        ],
        'lang' => [
          'type' => 'varchar_ascii',
          'length' => 32,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('multiline')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return 'multiline';
  }

}
