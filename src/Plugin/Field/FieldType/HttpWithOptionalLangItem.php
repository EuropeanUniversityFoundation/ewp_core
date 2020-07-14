<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'ewp_http_lang' field type.
 *
 * @FieldType(
 *   id = "ewp_http_lang",
 *   label = @Translation("HTTP with optional lang"),
 *   description = @Translation("EWP data type HTTPWithOptionalLang"),
 *   category = @Translation("EWP"),
 *   default_widget = "ewp_http_lang_default",
 *   default_formatter = "ewp_http_lang_default"
 * )
 */
class HttpWithOptionalLangItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      //
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['uri'] = DataDefinition::create('uri')
      ->setLabel(new TranslatableMarkup('URI'))
      ->setRequired(TRUE);

    $properties['lang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Language code'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'uri' => [
          'type' => 'varchar',
          'length' => 2048,
        ],
        'lang' => [
          'type' => 'varchar_ascii',
          'length' => 32,
        ],
      ],
      'indexes' => [
        'uri' => [['uri', 30]],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('uri')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl() {
    return Url::fromUri($this->uri, (array) $this->options);
  }

}
