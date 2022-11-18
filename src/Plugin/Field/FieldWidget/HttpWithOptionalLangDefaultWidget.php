<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ewp_core\LangCodeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ewp_http_lang_default' widget.
 *
 * @FieldWidget(
 *   id = "ewp_http_lang_default",
 *   module = "ewp_core",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "ewp_http_lang"
 *   }
 * )
 */
class HttpWithOptionalLangDefaultWidget extends WidgetBase implements ContainerFactoryPluginInterface {

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
    array $third_party_settings,
    LangCodeManager $lang_code_manager
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
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
      $configuration['third_party_settings'],
      $container->get('ewp_core.langcode')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      //
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = $element + [
      '#type' => 'container',
      '#attributes' => ['class' => ['inline-widget']],
    ];
    $element['#attached']['library'][] = 'ewp_core/inline_widget';

    $element['uri'] = [
      '#type' => 'url',
      '#default_value' => $items[$delta]->uri ?? NULL,
      '#maxlength' => 2048,
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    $cardinality = $this->fieldDefinition
      ->getFieldStorageDefinition()
      ->getCardinality();

    if ($cardinality === 1) {
      $element['uri']['#title'] = $element['#title'];
    }

    $lang_options = $this->langCodeManager->getOptions();
    $lang_exists = FALSE;

    $default_lang = $items[$delta]->lang ?? NULL;

    if (!empty($default_lang)) {
      foreach ($lang_options as $group => $list) {
        if (\array_key_exists($default_lang, $list)) {
          $lang_exists = TRUE;
          break;
        }
      }
    }

    if (!empty($default_lang) && !$lang_exists) {
      $extra_option = [$default_lang => $default_lang];
      $extra_group = [t('Current value') => $extra_option];

      $lang_options = \array_merge($extra_group, $lang_options);
    }

    $element['lang'] = [
      '#type' => 'select',
      '#options' => $lang_options,
      '#empty_option' => '- ' . t('Language') . ' -',
      '#empty_value' => '',
      '#default_value' => $default_lang,
      '#description' => t('Optional'),
    ];

    return $element;
  }

}
