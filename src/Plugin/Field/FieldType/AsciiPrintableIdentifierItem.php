<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'ascii_identifier' field type.
 */
#[FieldType(
  id: "ascii_identifier",
  module: "ewp_core",
  label: new TranslatableMarkup("ASCII Printable Identifier"),
  description: [
    new TranslatableMarkup("Stores a string to be used as an identifier."),
    new TranslatableMarkup("Allows only ASCII printable characters."),
  ],
  category: "ewp_core",
  default_widget: "ascii_identifier_default",
  default_formatter: "ascii_identifier_default",
)]
class AsciiPrintableIdentifierItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'max_length' => 64,
      'is_ascii' => TRUE,
      'case_sensitive' => TRUE,
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
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Identifier'))
      ->setSetting('case_sensitive', TRUE)
      ->setRequired(TRUE)
      ->addConstraint('Regex', [
        'pattern' => '/^[ -~]+$/',
        'message' => new TranslatableMarkup('ASCII printable characters only.'),
      ]);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'value' => [
          'type' => 'varchar_ascii',
          'length' => (int) $field_definition->getSetting('max_length'),
          'binary' => TRUE,
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
        '@max' => $max_length,
      ]);

      $constraint_manager = \Drupal::typedDataManager()
        ->getValidationConstraintManager();

      $constraints[] = $constraint_manager->create('ComplexData', [
        'value' => [
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
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['value'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

}
