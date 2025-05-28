<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Toobo\Bcp47;

/**
 * Validates the Language tag option constraint.
 */
final class LanguageTagOptionConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    $parts = explode('|', $value, 2);

    if (empty($parts[0])) {
      $this->context->addViolation($constraint->missingLanguageTag);
      return;
    }

    $tag = $parts[0];
    $args = ['@tag' => $tag];

    if (!Bcp47::isValidTag($tag)) {
      $this->context->addViolation($constraint->invalidLanguageTag, $args);
      return;
    }

    if ((count($parts) === 2) && empty($parts[1])) {
      $this->context->addViolation($constraint->missingLabel, $args);
      return;
    }
  }

}
