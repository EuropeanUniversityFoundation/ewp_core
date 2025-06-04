<?php

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Defines a protocol validation constraint for link URLs.
 */
#[Constraint(
  id: 'LinkHttps',
  label: new TranslatableMarkup('HTTPS protocol', [], ['context' => 'Validation'])
)]
class LinkHttpsConstraint extends SymfonyConstraint {

  /**
   * The error message if the URL does not follow the HTTPS protocol.
   *
   * @var string
   */
  public $message = "The URI '@uri' does not follow the HTTPS protocol.";

}
