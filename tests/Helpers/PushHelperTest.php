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
            "domain" => "api.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testInvalidToken() {
        $helper = new WrapItPushHelper($this->wrapit, "example_token");
    }

}
