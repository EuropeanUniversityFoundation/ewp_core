# EWP core

Drupal module providing EWP specific field types and other tools.

## Installation

Include the repository in your project's `composer.json` file:

    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/EuropeanUniversityFoundation/ewp_core"
        }
    ],

Then you can require the package as usual:

    composer require euf/ewp_core

Finally, install the module:

    drush en ewp_core

## Usage

The following field types become available in the Field UI so it can be added to any fieldable entity like any other field type:

### General purpose

  - ASCII Printable Identifier
  - String with optional lang
  - Multiline string with optional lang
  - HTTP with optional lang
  - HTTPS

### Select options

  - CEFR language level
  - EQF qualification level
  - Gender (as per ISO/IEC 5218)
