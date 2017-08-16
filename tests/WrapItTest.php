<?php

namespace WrapIt\Tests;

use PHPUnit\Framework\TestCase;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;

final class WrapItTest extends TestCase {

    public function testCreateFromValidConfig() {
        $wi = new WrapIt(array(
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
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
            "domain" => "test.wrapit.hu",
            "client_id" => null,
            "client_secret" => null
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig4() {
        $wi = new WrapIt(array(
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => null
        ));
    }

    /**
     * @expectedException \WrapIt\Exceptions\WrapItParameterException
     */
    public function testCreateFromInvalidConfig5() {
        $wi = new WrapIt(array(
            "domain" => "test.wrapit.hu",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
        ));
    }

    public function testClientIdReturnedSuccessfully() {
        $wi = new WrapIt(array(
            "domain" => "test.wrapit.hu",
            "client_id" => "2f32225f2fca95e119e82b47bf1fa091",
            "client_secret" => "YZubMTvz-Bo7W3slenIEInayXuvwU7BtUwIgD4TB589Qzp1SR-WalwN9f9u04whM"
        ));

        if ($wi->getClientId() != "2f32225f2fca95e119e82b47bf1fa091") {
            throw new Exception("Invalid Id");
        }
    }
}
