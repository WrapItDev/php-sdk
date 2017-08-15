<?php

namespace WrapIt\Tests\Helpers;

use PHPUnit\Framework\TestCase;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Helpers\WrapItLoginHelper;

final class LoginHelperTest extends TestCase {

    protected $helper;

    protected function setUp() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));
        $this->helper = new WrapItLoginHelper($wi);
    }

    public function testUrlGeneration() {
        $url = $this->helper->generateLoginUrl(array(
            "redirect_uri" => "https://google.com/",
            "scope" => array("profile", "mail")
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItResponseException
     */
    public function testTokenExchange() {
        $token = $this->helper->exchangeAccessToken(array(
            "redirect_uri" => "https://google.com/",
            "code" => "0123456"
        ));
    }

}
