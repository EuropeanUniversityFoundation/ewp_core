<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_multiline_lang' field type.
 *
 * @FieldType(
 *   id = "ewp_multiline_lang",
 *   label = @Translation("Multiline string with optional lang"),
 *   description = @Translation("EWP data type MultilineStringWithOptionalLang"),
 *   category = @Translation("EWP"),
 *   default_widget = "ewp_multiline_lang_default",
 *   default_formatter = "ewp_multiline_lang_default"
 * )
 */
class MultilineStringWithOptionalLangItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['multiline'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Text value'))
      ->setRequired(TRUE);

    $properties['lang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Language code'));

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

}
