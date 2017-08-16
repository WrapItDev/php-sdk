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
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
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
