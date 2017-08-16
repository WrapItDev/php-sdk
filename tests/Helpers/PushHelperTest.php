<?php

namespace WrapIt\Tests\Helpers;

use PHPUnit\Framework\TestCase;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Helpers\WrapItPushHelper;

final class PushHelperTest extends TestCase {

    protected $wrapit;

    protected function setUp() {
        $this->wrapit = new WrapIt(array(
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
        ));
    }

    public function testPushCorrectCreationWithToken() {
        $helper = new WrapItPushHelper($this->wrapit, "example_token");
    }

    public function testGenerateToken() {
        $helper = new WrapItPushHelper($this->wrapit);
    }

}
