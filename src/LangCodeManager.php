<?php

namespace Drupal\ewp_core;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Provides list of language codes.
 */
class LangCodeManager {

  use StringTranslationTrait;

  /**
   * An array of language code => language name pairs.
   */
  protected $languageCodes;

  /**
   * Primary language group label.
   */
  protected $primaryLabel;

  /**
   * Primary language list.
   */
  protected $primaryList;

  /**
   * Secondary language group label.
   */
  protected $secondaryLabel;

  /**
   * Secondary language list.
   */
  protected $secondaryList;

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    TranslationInterface $string_translation
  ) {
    $this->configFactory = $config_factory;
    $this->stringTranslation = $string_translation;
  }

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
    if (!isset($this->languageCodes)) {
      $this->languageCodes = static::getList();
    }

    $options = [];
    foreach ($this->languageCodes as $category => $array) {
      $group = [];
      foreach ($array as $key => $value) {
        $group[$key] = $value;
      }
      $options[$category] = $group;
    }

    return $options;
  }

  /**
   * Get an array of language code => language name pairs, as options.
   *
   * @return array
   *   An array of language code => language name pairs.
   */
  public function getConfigOptions(): array {
    $options = [];

    // Process primary language list.
    $lang_primary_label = $this->getPrimaryLabel();
    $lang_primary_list = $this->getPrimaryList();

    $primary_options = [];

    foreach ($lang_primary_list as $item) {
      $pair = \explode('|', $item, 2);
      $code = $pair[0];
      $name = (count($pair) === 2) ? $pair[1] : $code;

      $primary_options[$code] = $name;
    }

    if (!empty($primary_options)) {
      $options[$lang_primary_label] = $primary_options;
    }

    // Process secondary language list.
    $lang_secondary_label = $this->getSecondaryLabel();
    $lang_secondary_list = $this->getSecondaryList();

    $secondary_options = [];

    foreach ($lang_secondary_list as $item) {
      $pair = \explode('|', $item, 2);
      $code = $pair[0];
      $name = (count($pair) === 2) ? $pair[1] : $code;

      $secondary_options[$code] = $name;
    }

    if (!empty($secondary_options)) {
      $options[$lang_secondary_label] = $secondary_options;
    }

    return $options;
  }

  /**
   * Get the primary language group label.
   *
   * @return string
   *   The primary language group label.
   */
  public function getPrimaryLabel(): string {
    if (!isset($this->primaryLabel)) {
      $config = $this->configFactory->get('ewp_core.settings');

      // Process primary language list.
      $lang_primary_label = $config->get('lang_primary_group_label');
      $this->primaryLabel = (!empty($lang_primary_label))
        ? $lang_primary_label
        : $this->t('Primary languages');
    }

    return $this->primaryLabel;
  }

  /**
   * Get the primary language list.
   *
   * @return array
   *   The primary language list.
   */
  public function getPrimaryList(): array {
    if (!isset($this->primaryList)) {
      $config = $this->configFactory->get('ewp_core.settings');

      // Process primary language list.
      $lang_primary_list = (array) $config->get('lang_primary_list');
      $this->primaryList = (!empty($lang_primary_list))
        ? $lang_primary_list
        : ['en|English'];
    }

    return $this->primaryList;
  }

  /**
   * Get the secondary language group label.
   *
   * @return string
   *   The sesecondary language group label.
   */
  public function getSecondaryLabel(): string {
    if (!isset($this->secondaryLabel)) {
      $config = $this->configFactory->get('ewp_core.settings');

      // Process secondary language list.
      $lang_secondary_label = $config->get('lang_secondary_group_label');
      $this->secondaryLabel = (!empty($lang_secondary_label))
        ? $lang_secondary_label
        : $this->t('Secondary languages');
    }

    return $this->secondaryLabel;
  }

  /**
   * Get the secondary language list.
   *
   * @return array
   *   The secondary language list.
   */
  public function getSecondaryList(): array {
    if (!isset($this->secondaryList)) {
      $config = $this->configFactory->get('ewp_core.settings');

      // Process secondary language list.
      $lang_secondary_list = (array) $config->get('lang_secondary_list');
      $this->secondaryList = (!empty($lang_secondary_list))
        ? $lang_secondary_list
        : ['xx|undefined'];
    }

    return $this->secondaryList;
  }

}
