<?php

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the LinkHttps constraint.
 */
class LinkHttpsConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint): void {
    if (isset($value)) {
      // Disallow any URLs not using HTTPS protocol.
      if (parse_url($value, PHP_URL_SCHEME) !== 'https') {
        $this->context->addViolation($constraint->message, ['@uri' => $value]);
      }
    }
  }

}
