<?php
use Jvandemo\Ogone\Form;
/**
 * Example to generate an Ogone payment form
 * to initiate Ogone payments from your website
 *
 * @author       Jurgen Van de Moere (http://www.jvandemo.com)
 * @copyright    JobberID (http://www.jobberid.com) *
 */

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

