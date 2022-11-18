<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\OptGroup;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ewp_core\LangCodeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ewp_multiline_lang_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_multiline_lang_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_multiline_lang"
 *   }
 * )
 */
class MultilineStringWithOptionalLangDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Language code manager.
   *
   * @var \Drupal\ewp_core\LangCodeManager
   */
  protected $langCodeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    $label,
    $view_mode,
    array $third_party_settings,
    LangCodeManager $lang_code_manager
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->langCodeManager = $lang_code_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('ewp_core.langcode')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      // Implement default settings.
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      // Implement settings form.
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $language_options = $this->langCodeManager->getOptions();
    $language_codes = OptGroup::flattenOptions($language_options);

    $elements = [];

    foreach ($items as $delta => $item) {
      $code = $item->lang ?? NULL;
      $name = (!empty($code) && \array_key_exists($code, $language_codes))
        ? $language_codes[$code]->render()
        : $code;

      $elements[$delta] = [
        '#theme' => 'ewp_multiline_lang_default',
        '#string' => $item->multiline,
        '#langcode' => $code,
        '#langname' => $name,
      ];
    }

    return $elements;
  }

}
