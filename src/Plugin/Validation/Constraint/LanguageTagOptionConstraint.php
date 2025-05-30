<?php

declare(strict_types=1);

namespace Drupal\ewp_core\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Defines a Language tag option constraint.
 */
#[Constraint(
  id: 'LanguageTagOption',
  label: new TranslatableMarkup('Language tag option', [], ['context' => 'Validation'])
)]
final class LanguageTagOptionConstraint extends SymfonyConstraint {

  /**
   * The error message if the language tag is missing.
   *
   * @var string
   */
  public string $missingLanguageTag = "Missing language tag.";

  /**
   * The error message if the language tag is invalid.
   *
   * @var string
   */
  public string $invalidLanguageTag = "'@tag' is not a valid language tag.";

  /**
   * The error message if the language tag label is missing.
   *
   * @var string
   */
  public string $missingLabel = "Missing label for language tag '@tag'.";

}
