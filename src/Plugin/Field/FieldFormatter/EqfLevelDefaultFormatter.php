<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ewp_core\SelectOptionsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'eqf_level_default' formatter.
 */
#[FieldFormatter(
  id: 'eqf_level_default',
  label: new TranslatableMarkup('Default'),
  field_types: [
    'eqf_level',
  ],
)]
class EqfLevelDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * EQF level manager.
   *
   * @var \Drupal\ewp_core\SelectOptionsProviderInterface
   */
  protected $eqfLevelManager;

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
    SelectOptionsProviderInterface $eqf_level_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->eqfLevelManager = $eqf_level_manager;
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
      $container->get('ewp_core.eqf')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $eqf_levels = $this->eqfLevelManager->getSelectOptions();

    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'ewp_eqf_level_default',
        '#value' => ($item->value) ? $eqf_levels[$item->value] : NULL,
      ];
    }

    return $elements;
  }

}
