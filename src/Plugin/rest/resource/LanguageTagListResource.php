<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\rest\resource;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\rest\Attribute\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents Language tag config objects as resources.
 */
#[RestResource(
  id: "ewp_core_language_tag_list",
  label: new TranslatableMarkup("Language tag list"),
  uri_paths: [
    "canonical" => "/api/ewp/core/lang",
  ],
)]
final class LanguageTagListResource extends ResourceBase {

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    ConfigFactoryInterface $config_factory,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('config.factory')
    );
  }

  /**
   * Responds to GET requests.
   */
  public function get(): ResourceResponse {
    $config = $this->configFactory->get('ewp_core.settings');
    $raw = $config->getRawData();

    foreach (['_core', 'langcode'] as $key) {
      unset($raw[$key]);
    }

    $resource = [];

    foreach ($raw as $key => $value) {
      if (is_array($value)) {
        $resource[$key] = [];

        foreach ($value as $item) {
          $parts = explode('|', $item, 2);
          $resource[$key][$parts[0]] = $parts[1] ?? $parts[0];
        }
      }
      else {
        $resource[$key] = $value;
      }
    }

    return new ResourceResponse($resource);
  }

}
