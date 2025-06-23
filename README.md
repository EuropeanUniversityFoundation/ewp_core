# EWP core

Drupal module providing EWP specific field types and other tools.

See the **Erasmus Without Paper** [Architecture and Common Datatypes specification](https://github.com/erasmus-without-paper/ewp-specs-architecture/) for more information.

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

The following field types become available in the Field UI so they can be added to any fieldable entity like any other field type:

### EWP data types with constraints

  - ASCII Printable Identifier
  - HTTPS

### EWP data types with optional language tag

  - String with optional lang
  - Multiline string with optional lang
  - HTTP with optional lang
  - _Language tag only - added feature_

### Select options

  - EQF qualification level ([Wikipedia](https://en.wikipedia.org/wiki/European_Qualifications_Framework))
  - Gender (uses codes from [ISO/IEC 5218](https://www.iso.org/standard/36266.html))
  - _Deprecated: CEFR language level ([Wikipedia](https://en.wikipedia.org/wiki/Common_European_Framework_of_Reference_for_Languages))_

## Types provided by Drupal core or contrib

Not all data types are implemented, and some are already present in the Drupal ecosystem, such as:

  - UUID (assigned to every entity by Drupal)
  - Email (Email field in Drupal core)
  - HTTP (Link field in Drupal core)
  - Country (Country field from the [Country](https://www.drupal.org/project/country) module)

### Alternatives to module features in contrib

  - [Custom language field](https://www.drupal.org/project/languagefield)
  - [CEFRL module](https://www.drupal.org/project/cefrl)

The Country module approach of using the `country_manager` service from Drupal core can also be used within custom compound fields. In the case of language codes in compound fields, the list of options can be set in configuration.

## REST resources

This module ships with custom REST resources to expose the lists used for select options and language tags. See the [official documentation](https://www.drupal.org/docs/develop/drupal-apis/restful-web-services-api/custom-rest-resources) on how to enable and configure these resources.
