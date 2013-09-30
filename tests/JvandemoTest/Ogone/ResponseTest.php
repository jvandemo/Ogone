<?php

use Jvandemo\Ogone\Response;
use Zend\Config\Config;

class ReponseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Zend\Config\Config
     */
    public $config = null;

    /**
     * @var Jvandemo\Ogone\Response
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
        $params = array(
            'AMOUNT' => 100
        );

        $this->response = new Response($options, $params);
    }

    public function testParamsShouldBeAvailable()
    {
        $this->assertEquals(100, $this->response->getParam('AMOUNT'));
    }

    protected function _getConfig()
    {
        $config = new Config(include 'config/module.config.global.php');
        if(file_exists('config/module.config.local.php')){
            $config->merge(new Config(include 'config/module.config.local.php'));
        }
        return $config['jvandemo_ogone'];
    }

}