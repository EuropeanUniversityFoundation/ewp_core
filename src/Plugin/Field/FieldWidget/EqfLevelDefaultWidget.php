<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ewp_core\SelectOptionsProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'eqf_level_default' widget.
 *
 * @FieldWidget(
 *   id = "eqf_level_default",
 *   module = "ewp_core",
 *   label = @Translation("Select list"),
 *   field_types = {
 *     "eqf_level"
 *   }
 * )
 */
class EqfLevelDefaultWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  /**
   * EQF level manager.
   *
   * @var \Drupal\ewp_core\SelectOptionsProviderInterface
   */
  protected $eqfLevelManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    array $third_party_settings,
    SelectOptionsProviderInterface $eqf_level_manager,
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->eqfLevelManager = $eqf_level_manager;
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
      $container->get('ewp_core.eqf')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'select',
      '#options' => $this->eqfLevelManager->getSelectOptions(),
      '#empty_value' => '',
      '#default_value' => $items[$delta]->value ?? NULL,
    ];

    // If cardinality is 1, ensure a proper label is output for the field.
    $cardinality = $this->fieldDefinition
      ->getFieldStorageDefinition()
      ->getCardinality();

    if ($cardinality === 1) {
      $element['value']['#title'] = $element['#title'];
    }

    return $element;
  }

}
