<?php

use Jvandemo\Ogone\Form;
use Jvandemo\Ogone\Response;
use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;
use Zend\Config\Config;

class ReponseTest extends PHPUnit_Framework_TestCase
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
     * @var Zend\Http\Response
     */
    public $response = null;

    public function setUp()
    {
        $this->config = $this->_getConfig();

        // Define response options
        $options = array(
            'sha1OutPassPhrase' => $this->config['sha1_out_pass_phrase']
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
            'PSPID' => $this->config['pspid'],
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

    protected function _getConfig()
    {
        $config = new Config(include 'config/module.config.global.php');
        if(file_exists('config/module.config.local.php')){
            $config = $config->merge(new Config(include 'config/module.config.local.php'));
        }
        return $config['jvandemo_config'];
    }

}