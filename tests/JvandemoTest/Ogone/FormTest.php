<?php

use Jvandemo\Ogone\Form;

class FormTest extends PHPUnit_Framework_TestCase
{
    public $form = null;

    public function setUp()
    {

        // Define form options
        $options = array(
            'sha1InPassPhrase' => 'your_sha1_in_password',
            'formAction'       => Form::OGONE_TEST_URL,
        );

        // Define form parameters (see Ogone documentation for list)
        $params = array(
            'PSPID'        => 'your_ogone_pspid',
            'orderID'      => 'your_order_id',
            'amount'       => 100,
            'currency'     => 'EUR',
            'language'     => 'en',
            'CN'           => 'name of your client',
            'EMAIL'        => 'email of your client',
            'accepturl'    => 'where_to_go_if_accepted.html',
            'declineurl'   => 'where_to_go_if_declined.html',
            'exceptionurl' => 'where_to_go_if_exception_occurs.html',
            'cancelurl'    => 'where_to_go_if_cancelled.html',
        );

        $this->form = new Form($options, $params);
    }

    public function testFormHtmlShouldContainInputsForParamsPassedToConstructor()
    {
        $html = $this->form->render();
        $this->assertTrue(stripos($html, 'input type="hidden" name="PSPID"') !== false, 'PSPID input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="orderID"') !== false, 'orderID input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="amount"') !== false, 'amount input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="currency"') !== false, 'currency input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="language"') !== false, 'language input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="CN"') !== false, 'CN input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="EMAIL"') !== false, 'EMAIL input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="accepturl"') !== false, 'accepturl input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="declineurl"') !== false, 'declineurl input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="exceptionurl"') !== false, 'exceptionurl input does not exist');
        $this->assertTrue(stripos($html, 'input type="hidden" name="cancelurl"') !== false, 'cancelurl input does not exist');
    }
}