# Ogone classes for PHP

The PHP classes for working with the Ogone payment system allow you to
easily create Ogone payment forms and handle Ogone responses in an
efficient and flexible way.

## Requirements

The classes are only supported on PHP 5 and up.

## Installation

The easiest way to install this library is by using composer.

Add the following dependency to your `composer.json` file:

    {
        "require": {
            "jvandemo/ogone": "2.0.*"
        }
    }

## Change log

### 2.0.0

- Added composer support
- Introduced namespaces
- Added unit tests
- Fixed some coding standards warnings
- Added grunt support for unit testing and linting

### 1.0.0

- Added Ogone_Form for generating forms to interact with Ogone
- Added Ogone_Response for handling responses from Ogone