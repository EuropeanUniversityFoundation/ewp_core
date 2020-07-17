<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'gender_code_default' widget.
 *
 * @FieldWidget(
 *   id = "gender_code_default",
 *   module = "ewp_core",
 *   label = @Translation("Select list"),
 *   field_types = {
 *     "gender_code"
 *   }
 * )
 */
class GenderCodeDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $gender_codes = \ewp_core_get_human_sexes();
    $element['value'] = $element + [
        '#type' => 'select',
        '#options' => $gender_codes,
        '#empty_value' => '',
        '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
        '#description' => t('Select the Gender code'),
      ];

    return $element;
  }

}
