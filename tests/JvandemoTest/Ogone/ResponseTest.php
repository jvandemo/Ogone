<?php

use Jvandemo\Ogone\Form;
use Jvandemo\Ogone\Response;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;

class ReponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Zend\Http\Client
     */
    public $httpClient = null;

    /**
     * @var Zend\Http\Response
     */
    public $response = null;

    public function setUp()
    {

        // Define response options
        $options = array(
            'sha1OutPassPhrase' => 'your_sha1_out_password'
        );

        // Define response parameters (see Ogone documentation for list)
        $params = array();

        $this->response = new Response($options, $params);

        $this->httpClient = new HttpClient();
    }

    public function testPost()
    {
        $request = new HttpRequest();
        $request->setUri(Form::OGONE_TEST_URL);
        $request->setMethod(HttpRequest::METHOD_POST);

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

        $request->getPost()->fromArray($params);

        $request->getHeaders()->addHeader(
            \Zend\Http\Header\ContentType::fromString('Content-type: application/x-www-form-urlencoded')
        );

        $response = $this->httpClient->dispatch($request);

        echo 'Status: ' . $response->getStatusCode() . "\n";
        var_dump($response->getBody());
    }


}