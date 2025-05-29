<?php

declare(strict_types=1);

namespace Drupal\ewp_core;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Toobo\Bcp47;

/**
 * @todo Add class description.
 */
final class LanguageTagManager implements LanguageTagManagerInterface {

  const CONFIG_OBJECT = 'ewp_core.settings';

  const DEFAULT_LABEL_PRIMARY = 'Primary languages';
  const DEFAULT_TAG_PRIMARY = 'en';
  const DEFAULT_LABEL_SECONDARY = 'Secondary languages';
  const DEFAULT_TAG_SECONDARY = 'und';

  use StringTranslationTrait;

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
   * Constructs a LanguageTagManager object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    TranslationInterface $string_translation,
  ) {
    $this->configFactory = $config_factory;
    $this->stringTranslation = $string_translation;
  }

  /**
   * {@inheritdoc}
   */
  public function getSelectOptions($secondary = TRUE): array {
    $options = [];

    $primary_label = $this->getPrimaryLabel();
    $primary_list = $this->getPrimaryList();
    $primary_options = $this->toOptions($primary_list);

    $options[$primary_label] = $primary_options;

    if ($secondary) {
      $secondary_label = $this->getSecondaryLabel();
      $secondary_list = $this->getSecondaryList();
      $secondary_options = $this->toOptions($secondary_list);

      $options[$secondary_label] = $secondary_options;
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
      $config = $this->configFactory->get(self::CONFIG_OBJECT);
      $lang_primary_label = $config->get('lang_primary_group_label');
      $this->primaryLabel = (!empty($lang_primary_label))
        ? $lang_primary_label
        : $this->t(self::DEFAULT_LABEL_PRIMARY);
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
      $config = $this->configFactory->get(self::CONFIG_OBJECT);

      // Process primary language list.
      $lang_primary_list = (array) $config->get('lang_primary_list');
      $this->primaryList = (!empty($lang_primary_list))
        ? $lang_primary_list
        : [self::DEFAULT_TAG_PRIMARY];
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
      $config = $this->configFactory->get(self::CONFIG_OBJECT);
      $lang_secondary_label = $config->get('lang_secondary_group_label');
      $this->secondaryLabel = (!empty($lang_secondary_label))
        ? $lang_secondary_label
        : $this->t(self::DEFAULT_LABEL_SECONDARY);
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
      $config = $this->configFactory->get(self::CONFIG_OBJECT);

      // Process secondary language list.
      $lang_secondary_list = (array) $config->get('lang_secondary_list');
      $this->secondaryList = (!empty($lang_secondary_list))
        ? $lang_secondary_list
        : [DEFAULT_TAG_SECONDARY];
    }

    return $this->secondaryList;
  }

  /**
   * Converts a list of languages from config into select options.
   *
   * @param array $list
   *   The list of languages from config.
   *
   * @return array
   *   An array of languages keyed by language tag.
   */
  public function toOptions(array $list): array {
    $options = [];

    foreach ($list as $item) {
      $parts = explode('|', $item, 2);
      $tag = Bcp47::filterTag($parts[0]);
      $label = (count($parts) === 2) ? $this->t($parts[1]) : $tag;

      $options[$tag] = $label;
    }

    return $options;
  }

}
