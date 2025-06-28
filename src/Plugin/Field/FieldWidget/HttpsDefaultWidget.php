<?php

namespace Drupal\ewp_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;

/**
 * Plugin implementation of the 'ewp_https_default' widget.
 */
#[FieldWidget(
  id: 'ewp_https_default',
  label: new TranslatableMarkup('(DEPRECATED) Default'),
  field_types: ['ewp_https'],
)]
class HttpsDefaultWidget extends LinkWidget {

}
