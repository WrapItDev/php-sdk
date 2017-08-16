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
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
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
