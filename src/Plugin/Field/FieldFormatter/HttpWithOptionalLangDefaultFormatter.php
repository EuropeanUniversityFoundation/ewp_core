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
 *   label = @Translation("Link (clean URL)"),
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
    $language_codes = \Drupal::service('ewp_core.langcode')->getOptions();
    $langcodes = OptGroup::flattenOptions($language_codes);
    $elements = [];

    foreach ($items as $delta => $item) {
      $url = Html::escape($item->uri);
      # build a partial URL to use as title
      $url_host = parse_url($url, PHP_URL_HOST);
      $url_path = rtrim(parse_url($url, PHP_URL_PATH),"/");
      $title = ($url_path) ? $url_host . $url_path : $url_host;
      $langcode = ($item->lang) ? $item->lang : NULL;
      $langname = ($langcode) ? $langcodes[$langcode]->render() : NULL;
      $elements[$delta] = [
        '#theme' => 'ewp_http_lang_default',
        '#url' => $url,
        '#title' => $title,
        '#langcode' => $langcode,
        '#langname' => $langname,
      ];
    }

    return $elements;
  }

}
