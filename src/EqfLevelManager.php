<?php

namespace Drupal\ewp_core;

/**
 * Provides list of EQF levels.
 */
class EqfLevelManager {

  /**
   * An array of numeric key => EQF level pairs.
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
      // 1 => 'EQF-1',
      // 2 => 'EQF-2',
      // 3 => 'EQF-3',
      // 4 => 'EQF-4',
      5 => t('EQF-5 (Short cycle)'),
      6 => t('EQF-6 (Bachelor)'),
      7 => t('EQF-7 (Master)'),
      8 => t('EQF-8 (Doctorate)'),
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
  public function getOptions() {
    // Populate the EQF level list if it is not already populated.
    if (!isset($this->eqfLevels)) {
      $this->eqfLevels = static::getList();
    }

    $options = $this->eqfLevels;

    return $options;
  }

}
