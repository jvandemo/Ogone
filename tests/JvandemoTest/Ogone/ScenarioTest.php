<?php

use Jvandemo\Ogone\Form;
use Jvandemo\Ogone\Response;
use Zend\Config\Config;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;

class ScenarioTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Zend\Config\Config
     */
    public $config = null;

    /**
     * @var Zend\Http\Client
     */
    public $httpClient = null;

    /**
     * @var Jvandemo\Ogone\Response
     */
    public $response = null;

    /**
     * @var Jvandemo\Ogone\Form
     */
    public $form = null;

    public function setUp()
    {
        $this->config = $this->_getConfig();

        $this->response = new Response(
            array(
                 'sha1OutPassPhrase' => $this->config['sha1_out_pass_phrase']
            ),
            array()
        );

        $this->form = new Form(
            array(
                 'sha1InPassPhrase' => $this->config['sha1_in_pass_phrase'],
                 'formAction'       => Form::OGONE_TEST_URL,
            ),
            array(
                 'PSPID'        => $this->config['pspid'],
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
            )
        );

        $this->httpClient = new HttpClient();
    }

    public function testPost()
    {
        $request = new HttpRequest();

        $request->setUri(Form::OGONE_TEST_URL);
        $request->setMethod(HttpRequest::METHOD_POST);

        $request->getPost()->set('PSPID', $this->form->getParam('PSPID'));
        $request->getPost()->set('orderID', $this->form->getParam('orderID'));
        $request->getPost()->set('amount', $this->form->getParam('amount'));
        $request->getPost()->set('currency', $this->form->getParam('currency'));
        $request->getPost()->set('language', $this->form->getParam('language'));
        $request->getPost()->set('CN', $this->form->getParam('CN'));
        $request->getPost()->set('EMAIL', $this->form->getParam('EMAIL'));
        $request->getPost()->set('accepturl', $this->form->getParam('accepturl'));
        $request->getPost()->set('declineurl', $this->form->getParam('declineurl'));
        $request->getPost()->set('exceptionurl', $this->form->getParam('exceptionurl'));
        $request->getPost()->set('cancelurl', $this->form->getParam('cancelurl'));

        $request->getPost()->set('SHASign', $this->form->getSha1Sign());

        $request->getHeaders()->addHeader(
            \Zend\Http\Header\ContentType::fromString('Content-type: application/x-www-form-urlencoded')
        );

        $response = $this->httpClient->dispatch($request);

        $this->assertEquals(200, $response->getStatusCode(), 'Ogone response does not have the correct HTTP status code');

        $this->assertSelectCount('form[name="OGONE_CC_FORM"]', 1, $response, 'Ogone response does not include the correct form');

    }

    protected function _getConfig()
    {
        $config = new Config(include 'config/module.config.global.php');
        if (file_exists('config/module.config.local.php')) {
            $config->merge(new Config(include 'config/module.config.local.php'));
        }
        return $config['jvandemo_ogone'];
    }

}