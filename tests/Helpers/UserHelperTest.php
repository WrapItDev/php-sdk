<?php

namespace WrapIt\Tests\Helpers;

use PHPUnit\Framework\TestCase;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Helpers\WrapItUserHelper;

final class UserHelperTest extends TestCase {

    protected $helper;

    protected function setUp() {
        $wi = new WrapIt(array(
            "domain" => "api.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));
        $this->helper = new WrapItUserHelper($wi, "example_token");
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItResponseException
     */
    public function testUserData() {
        $data = $this->helper->getUserData();
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItResponseException
     */
    public function testUserPicture() {
        $url = $this->helper->getProfilePicture();
    }

}
