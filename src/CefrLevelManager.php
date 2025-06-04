<?php

namespace Drupal\ewp_core;

/**
 * Provides list of CEFR levels.
 */
class CefrLevelManager {

  /**
   * An array of CEFR level => CEFR level pairs.
   *
   * @var array|null
   */
  protected $cefrLevels;

  /**
   * Curated list of CEFR levels.
   *
   * @return array
   *   An array of CEFR level => CEFR level pairs.
   */
  public static function getList() {
    $cefr_levels = [
      'Basic User' => [
        'A1' => 'A1',
        'A2' => 'A2',
      ],
      'Independent User' => [
        'B1' => 'B1',
        'B2' => 'B2',
      ],
      'Proficient User' => [
        'C1' => 'C1',
        'C2' => 'C2',
      ],
    ];

    return $cefr_levels;
  }

  /**
   * Get an array of CEFR level => CEFR level pairs, as options.
   *
   * @return array
   *   An array of CEFR level => CEFR level pairs.
   *
   * @see \Drupal\ewp_core\CefrLevelManager::getList()
   */
  public function getOptions() {
    // Populate the CEFR level list if it is not already populated.
    if (!isset($this->cefrLevels)) {
      $this->cefrLevels = static::getList();
    }

    $options = [];
    foreach ($this->cefrLevels as $top => $array) {
      $group = [];
      foreach ($array as $key => $value) {
        $group[$key] = $value;
      }
      $options[$top] = $group;
    }

    return $options;
  }

}
