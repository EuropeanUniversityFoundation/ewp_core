<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\rest\resource;

use Drupal\rest\Attribute\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\ewp_core\GenderCodeManager;

/**
 * Provides ISO/IEC 5218:2004 Codes as a REST resource.
 */
#[RestResource(
  id: "ewp_core_gender_code_list",
  label: new TranslatableMarkup("Gender code list"),
  uri_paths: [
    "canonical" => "/api/ewp/core/gender",
  ],
)]
final class GenderCodeListResource extends ResourceBase {

  /**
   * Responds to GET requests.
   */
  public function get(): ResourceResponse {
    return new ResourceResponse(GenderCodeManager::getList());
  }

}
