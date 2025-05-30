<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\link\Plugin\Field\FieldType\LinkItem;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_https' field type.
 *
 * @FieldType(
 *   id = "ewp_https",
 *   label = @Translation("HTTPS"),
 *   description = {
 *     @Translation("Stores a URL string"),
 *     @Translation("Requires https:// protocol"),
 *   },
 *   category = "ewp_core",
 *   default_widget = "ewp_https_default",
 *   default_formatter = "ewp_https_default"
 * )
 */
class HttpsItem extends LinkItem {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['uri']->addConstraint('LinkHttps', []);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];

    return $element;
  }

}
