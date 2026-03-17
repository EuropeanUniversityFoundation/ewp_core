<?php

/**
 * @file
 * Views hooks for the EWP core module.
 */

declare(strict_types=1);

use Drupal\field\FieldStorageConfigInterface;

/**
 * Implements hook_field_views_data().
 */
function ewp_core_field_views_data(FieldStorageConfigInterface $field_storage) : array {
  $data = views_field_default_views_data($field_storage);

  if ($field_storage->getType() === 'eqf_level') {
    foreach ($data as $table_name => $table_data) {
      $property_name = implode('_', [$field_storage->getName(), 'value']);

      $data[$table_name][$property_name]['filter']['id'] = 'eqf_level';
    }
  }

  return $data;
}
