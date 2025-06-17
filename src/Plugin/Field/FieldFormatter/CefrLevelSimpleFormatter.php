<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\OptGroup;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ewp_core\CefrLevelManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'cefr_level_simple' formatter.
 */
#[FieldFormatter(
  id: 'cefr_level_simple',
  label: new TranslatableMarkup('Simple (code only)'),
  field_types: [
    'cefr_level',
  ],
)]
class CefrLevelSimpleFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * CEFR level manager.
   *
   * @var \Drupal\ewp_core\CefrLevelManager
   */
  protected $cefrLevelManager;

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
    CefrLevelManager $cefr_level_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->cefrLevelManager = $cefr_level_manager;
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
      $container->get('ewp_core.cefr')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $cefr_levels = $this->cefrLevelManager->getOptions();

    $options = OptGroup::flattenOptions($cefr_levels);

    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $options[$item->value]];
    }

    return $elements;
  }

}
