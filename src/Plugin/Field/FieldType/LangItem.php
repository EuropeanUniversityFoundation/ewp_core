<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_lang' field type.
 */
#[FieldType(
  id: "ewp_lang",
  module: "ewp_core",
  label: new TranslatableMarkup("Language tag"),
  description: [
    new TranslatableMarkup("Stores an IETF BCP 47 language tag."),
    new TranslatableMarkup("e.g. el for Greek, el-Latn for Greek in Latin script."),
  ],
  category: "ewp_lang",
  default_widget: "ewp_lang_default",
  default_formatter: "ewp_lang_default",
)]
class LangItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['lang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Language tag'))
      ->setRequired(TRUE)
      ->addConstraint('ValidLanguageTag');

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
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
  public static function mainPropertyName() {
    return 'lang';
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('lang')->getValue();
    return $value === NULL || $value === '';
  }

}
