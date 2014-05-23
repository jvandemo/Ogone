# ATTENTION

This project is looking for a motivated maintainer.

If you are interested, please contact me: [@jvandemo](http://twitter.com/jvandemo).

# Ogone classes for PHP

PHP classes for working with the Ogone payment system allow you to
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

## How to use the classes

The first step is to create a form to initiate a payment:

    use Jvandemo\Ogone\Form;

    // Define form options
    // See Ogone_Form for list of supported options
    $options = array(
        'sha1InPassPhrase' => 'your_sha1_in_password',
        'formAction'       => Form::OGONE_TEST_URL,
    );

    // Define form parameters (see Ogone documentation for list)
    // Default parameter values can be set in Ogone_Form if required
    $params = array(
        'PSPID' => 'your_ogone_pspid',
        'orderID' => 'your_order_id',
        'amount' => 100,
        'currency' => 'EUR',
        'language' => 'en',
        'CN' => 'name of your client',
        'EMAIL' => 'email of your client',
        'accepturl' => 'where_to_go_if_accepted.html',
        'declineurl' => 'where_to_go_if_declined.html',
        'exceptionurl' => 'where_to_go_if_exception_occurs.html',
        'cancelurl' => 'where_to_go_if_cancelled.html',
    );

    // Instantiate form
    $form = new Form($options, $params);

    // You can also add parameters after instantiation
    // with the addParam() method
    $form->addParam('CN', 'Jurgen Van de Moere')
         ->addParam('EMAIL', 'email@email.com')
         ->addParam('language', 'en');

    // Automatically generate HTML form with all params and SHA1Sign
    echo $form->render();

The second step is to create a script that handles the response by Ogone:

    use Jvandemo\Ogone\Response;

    // Define response options
    // See Ogone_Response for list of supported options
    $options = array(
        'sha1OutPassPhrase' => 'your_sha1_out_password'
    );

    // Define array of values returned by Ogone
    // Parameters are validated and filtered automatically
    // so it is safe to specify a superglobal variable
    // like $_POST or $_GET if you don't want to
    // specify all parameters manually
    $params = $_POST;

    // Instantiate response
    $response = new Response($options, $params);

    // Check if response by Ogone is valid
    // The SHA1Sign is calculated automatically and
    // verified with the SHA1Sign provided by Ogone
    if(! $response->isValid()) {
        // Reponse is not valid so handle accordingly
        exit('The response is not valid');
    }

    // Use the dump() method to dump the whole response
    // if you need to investigate the response when debugging
    $response->dump();

    // Use the getParam() method to retrieve
    // parameters returned by Ogone
    $creditCard = $response->getParam('CreditCard');
    $amount = $response->getParam('amount');

    // Handle further processing of your website
    // such as saving payment details to database
    // or sending confirmation email to client

    // ...

This code is also available in the `/examples` directory.

## Unit testing

The tests folder contains basic unit tests plus an additional scenario test that actually
connects to the Ogone test server with your personal Ogone credentials to check if things
are working correctly.

To configure the scenario test with your Ogone details, copy
`config/module.config.global.php` to `module.config.local.php` and fill in your Ogone details:

    return array(
        'jvandemo_ogone' => array(
            'pspid' => 'your_ogone_pspid',
            'sha1_in_pass_phrase' => 'your_sha1_in_password',
            'sha1_out_pass_phrase' => 'your_sha1_out_password'
        )
    );

The `.gitignore` file is configured to ignore `module.config.local.php` so you don't have to worry
about exposing your Ogone details when creating your own public repository.

To actually run the unit test suite, run:

    grunt

## Change log

### 1.0.0

- Added Ogone_Form for generating forms to interact with Ogone
- Added Ogone_Response for handling responses from Ogone

### 2.0.0

- Added composer support
- Introduced namespaces
- Added unit tests
- Fixed some coding standards warnings
- Added grunt support for unit testing and linting
- Added semantic versioning

### 2.1.0

- Added additional unit tests
- Added scenario test
- Added config file support
