<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\rest\resource;

use Drupal\rest\Attribute\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\ewp_core\EqfLevelManager;

/**
 * Provides EQF Levels as a REST resource.
 */
#[RestResource(
  id: "ewp_core_eqf_level_list",
  label: new TranslatableMarkup("EQF Level list"),
  uri_paths: [
    "canonical" => "/api/ewp/core/eqf",
  ],
)]
final class EqfLevelListResource extends ResourceBase {

  /**
   * Responds to GET requests.
   */
  public function get(): ResourceResponse {
    return new ResourceResponse(EqfLevelManager::getList());
  }

}
