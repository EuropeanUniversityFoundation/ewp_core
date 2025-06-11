<?php

declare(strict_types=1);

namespace Drupal\ewp_core;

/**
 * Defines an interface for a select options provider service.
 */
interface SelectOptionsProviderInterface {

  /**
   * Provides an array of select options to be used in form elements.
   *
   * @return array
   *   Flat or nested array of select options with keys and option labels.
   */
  public function getSelectOptions(): array;

}
