<?php

namespace Drupal\ewp_core\Plugin\views\filter;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Attribute\ViewsFilter;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\ewp_core\SelectOptionsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides filtering for EQF Level.
 *
 * @ingroup views_filter_handlers
 */
#[ViewsFilter("eqf_level")]
class EqfLevelFilter extends InOperator implements ContainerFactoryPluginInterface {

  /**
   * The EQF level service.
   *
   * @var \Drupal\ewp_core\SelectOptionsProviderInterface
   */
  protected $eqfLevelManager;

  /**
   * Constructs a new EqfLevelFilter instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\ewp_core\SelectOptionsProviderInterface $eqfLevelManager
   *   The EQF level service.
   */
  public function __construct(
    $configuration,
    $plugin_id,
    $plugin_definition,
    SelectOptionsProviderInterface $eqfLevelManager,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->eqfLevelManager = $eqfLevelManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('ewp_core.eqf'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    $this->valueOptions = $this->eqfLevelManager->getSelectOptions();

    return $this->valueOptions;
  }

}
