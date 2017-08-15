<?php

namespace WrapIt\Tests;

use PHPUnit\Framework\TestCase;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;

final class WrapItTest extends TestCase {

    public function testCreateFromValidConfig() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));
    }


    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig() {
        $wi = new WrapIt(array());
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig2() {
        $wi = new WrapIt(array(
            "domain" => null,
            "client_id" => null,
            "client_secret" => null
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig3() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => null,
            "client_secret" => null
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig4() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => null
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig5() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_secret" => "test_client_secret"
        ));
    }

    public function testClientIdReturnedSuccessfully() {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));

        if ($wi->getClientId() != "test_client_id") {
            throw new Exception("Invalid Id");
        }
    }
}
