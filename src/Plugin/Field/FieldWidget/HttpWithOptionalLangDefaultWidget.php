<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\ewp_core\SelectOptionsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ewp_http_lang_default' widget.
 */
#[FieldWidget(
  id: 'ewp_http_lang_default',
  label: new TranslatableMarkup('Default'),
  field_types: ['ewp_http_lang'],
)]
class HttpWithOptionalLangDefaultWidget extends LinkWidget implements ContainerFactoryPluginInterface {

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
    array $third_party_settings,
    SelectOptionsProviderInterface $language_tag_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
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
      $configuration['third_party_settings'],
      $container->get('ewp_core.language_tag')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['inline'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['inline-widget']],
      '#tree' => TRUE,
      '#weight' => -100,
    ];
    $element['#attached']['library'][] = 'ewp_core/inline_widget';

    $element['uri']['#attributes']['class'] = ['inline-shrink'];
    $element['inline']['uri'] = $element['uri'];
    unset($element['uri']);

    $lang_options = $this->languageTagManager->getSelectOptions();
    $lang_exists = FALSE;

    $default_lang = $items[$delta]->lang ?? NULL;

    if (!empty($default_lang)) {
      foreach ($lang_options as $list) {
        if (\array_key_exists($default_lang, $list)) {
          $lang_exists = TRUE;
          break;
        }
      }
    }

    if (!empty($default_lang) && !$lang_exists) {
      $extra_option = [$default_lang => $default_lang];
      $extra_group = [$this->t('Current value')->render() => $extra_option];

      $lang_options = \array_merge($extra_group, $lang_options);
    }

    $element['inline']['lang'] = [
      '#type' => 'select',
      '#options' => $lang_options,
      '#empty_option' => '- ' . $this->t('Language') . ' -',
      '#empty_value' => '',
      '#default_value' => $default_lang,
      '#description' => $this->t('Optional'),
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    $cardinality = $this->fieldDefinition
      ->getFieldStorageDefinition()
      ->getCardinality();

    if ($cardinality === 1) {
      $element['inline']['lang']['#title'] = '&nbsp;';
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function validateTitleElement(&$element, FormStateInterface $form_state, $form) {
    if ($element['inline']['uri']['#value'] !== '' && $element['title']['#value'] === '') {
      $message = new TranslatableMarkup('@title field is required if there is @uri input.', [
        '@title' => $element['title']['#title'],
        '@uri' => $element['uri']['#title'],
      ]);
      $form_state->setError($element['title'], $message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function validateTitleNoLink(&$element, FormStateInterface $form_state, $form) {
    if ($element['inline']['uri']['#value'] === '' && $element['title']['#value'] !== '') {
      $message = new TranslatableMarkup('The @uri field is required when the @title field is specified.', [
        '@title' => $element['title']['#title'],
        '@uri' => $element['uri']['#title'],
      ]);
      $form_state->setError($element['inline']['uri'], $message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      foreach ($value['inline'] as $key => $prop) {
        $value[$key] = $prop;
      }
      unset($value['inline']);
    }

    return parent::massageFormValues($values, $form, $form_state);
  }

}
