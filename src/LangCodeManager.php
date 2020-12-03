<?php

namespace Drupal\ewp_core;

/**
 * Provides list of language codes.
 */
class LangCodeManager {

  /**
   * An array of language code => language name pairs.
   */
  protected $language_codes;

  /**
   * Curated list of ISO 639-1 language codes.
   *
   * @return array
   *   An array of language code => language name pairs.
   */
  public static function getList() {
    $language_codes = [
      'EU languages' => [
        'bg' => t('Bulgarian'),
        'bg-Latn' => t('Bulgarian (Latin)'),
        'hr' => t('Croatian'),
        'cs' => t('Czech'),
        'da' => t('Danish'),
        'nl' => t('Dutch, Flemish'),
        'en' => t('English'),
        'et' => t('Estonian'),
        'fi' => t('Finnish'),
        'fr' => t('French'),
        'de' => t('German'),
        'el' => t('Greek'),
        'el-Latn' => t('Greek (Latin)'),
        'hu' => t('Hungarian'),
        'ga' => t('Irish'),
        'it' => t('Italian'),
        'lv' => t('Latvian'),
        'lt' => t('Lithuanian'),
        'lb' => t('Luxembourgish'),
        'mt' => t('Maltese'),
        'pl' => t('Polish'),
        'pt' => t('Portuguese'),
        'ro' => t('Romanian'),
        'sk' => t('Slovak'),
        'sl' => t('Slovene'),
        'es' => t('Spanish'),
        'sv' => t('Swedish'),
      ],
      'Other languages' => [
        'sq' => t('Albanian'),
        // 'ar' => t('Arabic'),
        'hy' => t('Armenian'),
        'hy-Latn' => t('Armenian (Latin)'),
        'az' => t('Azerbaijani'),
        'be' => t('Belarusian'),
        'be-Latn' => t('Belarusian (Latin)'),
        'bs-Cyrl' => t('Bosnian (Cyrillic)'),
        'bs-Latn' => t('Bosnian (Latin)'),
        // 'zh' => t('Chinese'),
        'ka' => t('Georgian'),
        'ka-Latn' => t('Georgian (Latin)'),
        'is' => t('Icelandic'),
        'mk' => t('Macedonian'),
        'mk-Latn' => t('Macedonian (Latin)'),
        'no' => t('Norwegian'),
        'ru' => t('Russian'),
        'ru-Latn' => t('Russian (Latin)'),
        'sr-Cyrl' => t('Serbian (Cyrillic)'),
        'sr-Latn' => t('Serbian (Latin)'),
        'tr' => t('Turkish'),
        'uk' => t('Ukrainian'),
        'uk-Latn' => t('Ukrainian (Latin)'),
        'xx' => t('- not listed -'),
      ],
    ];

    return $language_codes;
  }

  /**
   * Get an array of language code => language name pairs, as options.
   *
   * @return array
   *   An array of language code => language name pairs.
   *
   * @see \Drupal\ewp_core\LangCodeManager::getList()
   */
  public function getOptions() {
    // Populate the language code list if it is not already populated.
    if (!isset($this->language_codes)) {
      $this->language_codes = static::getList();
    }

    $options = [];
    foreach ($this->language_codes as $category => $array) {
      $group = [];
      foreach ($array as $key => $value) {
        $group[$key] = $value;
      }
      $options[$category] = $group;
    }

    return $options;
  }

}
