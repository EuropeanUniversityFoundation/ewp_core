<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ewp_core\GenderCodeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'gender_code_default' formatter.
 *
 * @FieldFormatter(
 *   id = "gender_code_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "gender_code"
 *   }
 * )
 */
class GenderCodeDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Gender code manager.
   *
   * @var \Drupal\ewp_core\GenderCodeManager
   */
  protected $genderCodeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    $label,
    $view_mode,
    array $third_party_settings,
    GenderCodeManager $gender_code_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->genderCodeManager = $gender_code_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('ewp_core.gender')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $gender_codes = $this->genderCodeManager->getSelectOptions();

    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'ewp_gender_code_default',
        '#value' => $gender_codes[$item->value] ?? NULL,
      ];
    }

    return $elements;
  }

}
