<?php

namespace Drupal\ewp_core;

/**
 * Provides ISO/IEC 5218:2004 Codes for the representation of human sexes.
 *
 * In EWP these are treated as Gender codes.
 */
class GenderCodeManager {

  /**
   * An array of numeric key => Gender code pairs.
   *
   * @var array|null
   */
  protected $genderCodes;

  /**
   * Curated list of Gender codes.
   *
   * @return array
   *   An array of numeric key => Gender code pairs.
   */
  public static function getList() {
    $gender_codes = [
      0 => t('Not known'),
      1 => t('Male'),
      2 => t('Female'),
      9 => t('Not applicable'),
    ];

    return $gender_codes;
  }

  /**
   * Get an array of numeric key => Gender code pairs, as options.
   *
   * @return array
   *   An array of numeric key => Gender code pairs.
   *
   * @see \Drupal\ewp_core\GenderCodeManager::getList()
   */
  public function getOptions() {
    // Populate the Gender code list if it is not already populated.
    if (!isset($this->genderCodes)) {
      $this->genderCodes = static::getList();
    }

    $options = [];
    foreach ($this->genderCodes as $key => $value) {
      $options[$key] = $value;
    }

    return $options;
  }

}
