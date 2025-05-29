<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Valid language tag constraint.
 *
 * @Constraint(
 *   id = "ValidLanguageTag",
 *   label = @Translation("Valid language tag", context = "Validation"),
 * )
 */
final class ValidLanguageTagConstraint extends Constraint {

  /**
   * The error message if the language tag is invalid.
   *
   * @var string
   */
  public string $invalidLanguageTag = "'@tag' is not a valid language tag.";

}
