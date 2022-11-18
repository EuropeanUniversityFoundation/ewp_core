<?php

namespace Drupal\ewp_core\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ewp_https_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ewp_https_default",
 *   label = @Translation("Link (clean URL)"),
 *   field_types = {
 *     "ewp_https"
 *   }
 * )
 */
class HttpsDefaultFormatter extends FormatterBase {

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
    $elements = [];

    foreach ($items as $delta => $item) {
      $url = Html::escape($item->uri);
      // Build a partial URL to use as title.
      $url_host = parse_url($url, PHP_URL_HOST);
      $url_path = rtrim(parse_url($url, PHP_URL_PATH),"/");

      $title = ($url_path) ? $url_host . $url_path : $url_host;

      $elements[$delta] = [
        '#theme' => 'ewp_https_default',
        '#url' => $url,
        '#title' => $title,
      ];
    }

    return $elements;
  }

}
