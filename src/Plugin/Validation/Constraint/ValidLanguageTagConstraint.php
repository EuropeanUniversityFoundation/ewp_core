<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides a Valid language tag constraint.
 */
#[Constraint(
  id: 'ValidLanguageTag',
  label: new TranslatableMarkup('Valid language tag', [], ['context' => 'Validation'])
)]
final class ValidLanguageTagConstraint extends SymfonyConstraint {

  /**
   * The error message if the language tag is invalid.
   *
   * @var string
   */
  public string $invalidLanguageTag = "'@tag' is not a valid language tag.";

}
