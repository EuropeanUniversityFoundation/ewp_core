<?php

namespace Drupal\ewp_core\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\link\Plugin\Field\FieldType\LinkItem;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'ewp_https' field type.
 */
#[FieldType(
  id: "ewp_https",
  module: "ewp_core",
  label: new TranslatableMarkup("HTTPS"),
  description: [
    new TranslatableMarkup("Stores a URL string, optional varchar link text, and optional blob of attributes to assemble a link."),
    new TranslatableMarkup("Requires https:// protocol."),
  ],
  category: "ewp_core",
  default_widget: "ewp_https_default",
  default_formatter: "ewp_https_default",
  constraints: [
    "LinkType" => [],
    "LinkAccess" => [],
    "LinkExternalProtocols" => [],
    "LinkNotExistingInternal" => [],
  ]
)]
class HttpsItem extends LinkItem {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['uri']->addConstraint('LinkHttps', []);

    return $properties;
  }

}
