<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

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
class EqfLevelDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $eqf_levels = \ewp_core_get_eqf_levels();
    $element['value'] = $element + [
        '#type' => 'select',
        '#options' => $eqf_levels,
        '#empty_value' => '',
        '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
        '#description' => t('Select the EQF level'),
      ];

    return $element;
  }

}
