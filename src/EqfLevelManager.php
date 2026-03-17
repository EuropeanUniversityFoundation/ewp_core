<?php

namespace Drupal\ewp_core;

use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides list of EQF levels.
 */
class EqfLevelManager implements SelectOptionsProviderInterface {

  /**
   * An array of numeric key => EQF level pairs.
   *
   * @var array|null
   */
  protected $eqfLevels;

  /**
   * Curated list of EQF levels.
   *
   * @return array
   *   An array of numeric key => EQF level pairs.
   */
  public static function getList() {
    $eqf_levels = [
      1 => new TranslatableMarkup('EQF-1'),
      2 => new TranslatableMarkup('EQF-2'),
      3 => new TranslatableMarkup('EQF-3'),
      4 => new TranslatableMarkup('EQF-4'),
      5 => new TranslatableMarkup('EQF-5 (Short cycle)'),
      6 => new TranslatableMarkup('EQF-6 (Bachelor)'),
      7 => new TranslatableMarkup('EQF-7 (Master)'),
      8 => new TranslatableMarkup('EQF-8 (Doctorate)'),
    ];

    return $eqf_levels;
  }

  /**
   * Get an array of numeric key => EQF level pairs, as options.
   *
   * @return array
   *   An array of numeric key => EQF level pairs.
   *
   * @see \Drupal\ewp_core\EqfLevelManager::getList()
   */
  public function getSelectOptions(): array {
    // Populate the EQF level list if it is not already populated.
    if (!isset($this->eqfLevels)) {
      $this->eqfLevels = static::getList();
    }

    $options = [];
    foreach ($this->eqfLevels as $key => $value) {
      $options[$key] = $value;
    }

    return $options;
  }

}
