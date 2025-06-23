<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\OptGroup;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ewp_core\SelectOptionsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ewp_lang_default' formatter.
 */
#[FieldFormatter(
  id: 'ewp_lang_default',
  label: new TranslatableMarkup('Default'),
  field_types: [
    'ewp_lang',
  ],
)]
class LangDefaultFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Language tag manager.
   *
   * @var \Drupal\ewp_core\SelectOptionsProviderInterface
   */
  protected $languageTagManager;

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
    SelectOptionsProviderInterface $language_tag_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->languageTagManager = $language_tag_manager;
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
      $container->get('ewp_core.language_tag')
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
  public function viewElements(FieldItemListInterface $items, $langtag) {
    $language_options = $this->languageTagManager->getSelectOptions();
    $language_tags = OptGroup::flattenOptions($language_options);

    $elements = [];

    foreach ($items as $delta => $item) {
      $tag = $item->lang ?? NULL;
      $label = (!empty($tag) && \array_key_exists($tag, $language_tags))
        ? $language_tags[$tag]
        : $tag;

      $elements[$delta] = ['#markup' => $label];
    }

    return $elements;
  }

}
