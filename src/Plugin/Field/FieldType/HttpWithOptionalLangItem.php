<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

// use Drupal\Core\Field\FieldDefinitionInterface;
// use Drupal\Core\Field\FieldItemBase;
use Drupal\link\Plugin\Field\FieldType\LinkItem;
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
class HttpWithOptionalLangItem extends LinkItem {

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
    // $properties['uri'] = DataDefinition::create('uri')
    //   ->setLabel(new TranslatableMarkup('URI'))
    //   ->setRequired(TRUE);
    $properties = parent::propertyDefinitions($field_definition);

    $properties['lang'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Language code'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    $schema['columns'] += [
      'lang' => [
        'type' => 'varchar_ascii',
        'length' => 32,
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];

    return $element;
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
