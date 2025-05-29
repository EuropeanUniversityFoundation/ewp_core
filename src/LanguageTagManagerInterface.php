<?php

declare(strict_types=1);

namespace Drupal\ewp_core;

/**
 * Defines an interface for an IETF BCP47 language tag manager.
 */
interface LanguageTagManagerInterface {

  /**
   * Provides an array of labeled language tags to be used in select widgets.
   *
   * @return array
   *   An array of languages keyed by language tag.
   */
  public function getSelectOptions(): array;

}
