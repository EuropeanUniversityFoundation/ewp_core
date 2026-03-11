<?php

/**
 * Replaces empty strings with NULL in the 'lang' property of language typed fields.
 */
function ewp_core_post_update_nullify_empty_lang(&$sandbox) {
  $entity_field_manager = \Drupal::service('entity_field.manager');
  $entity_type_manager = \Drupal::entityTypeManager();
  $database = \Drupal::database();

  $field_types = [
    'ewp_http_lang',
    'ewp_multiline_lang',
    'ewp_string_lang',
  ];

  foreach ($field_types as $field_type) {
    $field_map = $entity_field_manager->getFieldMapByFieldType($field_type);

    foreach ($field_map as $entity_type_id => $fields) {
      $storage = $entity_type_manager->getStorage($entity_type_id);
      
      if (!$storage instanceof \Drupal\Core\Entity\Sql\SqlEntityStorageInterface) {
        continue;
      }

      $table_mapping = $storage->getTableMapping();
      $storage_definitions = $entity_field_manager->getFieldStorageDefinitions($entity_type_id);
      
      foreach (array_keys($fields) as $field_name) {
        if (!isset($storage_definitions[$field_name])) {
          continue;
        }
        
        $storage_definition = $storage_definitions[$field_name];
        
        $column = $table_mapping->getFieldColumnName($storage_definition, 'lang');
        $tables = $table_mapping->getAllFieldTableNames($field_name);

        foreach ($tables as $table) {
          $database->update($table)
            ->expression($column, "NULLIF($column, '')")
            ->condition($column, '', '=')
            ->execute();
        }
      }
    }
  }

  return 'Database columns for the "lang" property have been updated to NULL where empty.';
}