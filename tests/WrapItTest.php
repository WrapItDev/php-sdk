<?php

namespace WrapIt\Tests;

use \PHPUnit\Framework\TestCase;

use \WrapIt\WrapIt;
use \WrapIt\Exception\WrapItParameterException;

final class WrapItTest extends TestCase {

    public function testCreateFromValidConfig()
    {
        $wi = new WrapIt(array(
            "domain" => "testing.wrapit.hu",
            "client_id" => "test_client_id",
            "client_secret" => "test_client_secret"
        ));
    }


    /**
     * @expectedException \WrapIt\Exception\WrapItParameterException
     */
    public function testCreateFromInvalidConfig()
    {
        $wi = new WrapIt(array());
    }

    public function testClientIdReturnedSuccessfully()
    {
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
