<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ewp_string_lang' field type.
 *
 * @FieldType(
 *   id = "ewp_string_lang",
 *   label = @Translation("String with optional lang"),
 *   description = {
 *     @Translation("Stores a short string"),
 *     @Translation("Stores an optional language code"),
 *     @Translation("For example, 'en' => 'English'"),
 *   },
 *   category = "ewp_lang",
 *   default_widget = "ewp_string_lang_default",
 *   default_formatter = "ewp_string_lang_default"
 * )
 */
class StringWithOptionalLangItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'max_length' => 255,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['max_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum length'),
      '#default_value' => $this->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => $this->t('The maximum length of the field in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['string'] = DataDefinition::create('string')
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
        'string' => [
          'type' => 'varchar',
          'length' => (int) $field_definition->getSetting('max_length'),
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
  public function getConstraints() {
    $constraints = parent::getConstraints();

    if ($max_length = $this->getSetting('max_length')) {
      $message = $this->t('%name: may not be longer than @max characters.', [
        '%name' => $this->getFieldDefinition()->getLabel(),
        '@max' => $max_length
      ]);

      $constraint_manager = \Drupal::typedDataManager()
        ->getValidationConstraintManager();

      $constraints[] = $constraint_manager->create('ComplexData', [
        'string' => [
          'Length' => [
            'max' => $max_length,
            'maxMessage' => $message,
          ],
        ],
      ]);
    }

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('string')->getValue();
    return $value === NULL || $value === '';
  }

}
