<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\OptGroup;

/**
 * Plugin implementation of the 'ewp_http_lang_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_http_lang_default",
 *   label = @Translation("Default (plain text)"),
 *   field_types = {
 *     "ewp_http_lang"
 *   }
 * )
 */
class HttpWithOptionalLangDefaultFormatter extends FormatterBase {

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
    $language_codes = \ewp_core_get_language_codes();
    $langcodes = OptGroup::flattenOptions($language_codes);
    $elements = [];

    foreach ($items as $delta => $item) {
      $url = Html::escape($item->uri);
      $langcode = $item->lang;
      $langname = $langcodes[$langcode]->render();
      $elements[$delta] = [
        '#theme' => 'ewp_http_lang_default',
        '#url' => $url,
        '#langcode' => $langcode,
        '#langname' => $langname,
      ];
    }

    return $elements;
  }

}
