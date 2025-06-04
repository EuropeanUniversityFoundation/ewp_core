<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Toobo\Bcp47;

/**
 * Validates the Valid language tag constraint.
 */
final class ValidLanguageTagConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    if (empty($value)) {
      // Out of scope, add a NotBlank constraint if needed.
      return;
    }

    $args = ['@tag' => $value];

    if (!Bcp47::isValidTag($value)) {
      $this->context
        ->buildViolation($constraint->invalidLanguageTag, $args)
        ->atPath($this->context->getPropertyPath())
        ->addViolation();
    }
  }

}
