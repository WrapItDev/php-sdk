<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Http\WrapItApiRequester;
use WrapIt\Http\WrapItPushRequester;
use WrapIt\Helpers\Helper;

/**
 * Class WrapItUserHelper
 *
 * @package WrapIt
 */
class WrapItPushHelper extends Helper {

    protected $access_token = null;

    protected $push_requester;

    public function __construct($wi, $access_token = null) {
        parent::__construct($wi);

        $this->access_token = $access_token;
        $this->push_requester = new WrapItPushRequester($this->domain, $this->getAccessToken());
    }

    private function getAccessToken() {
        if ($this->access_token != null) {
            return $this->access_token;
        }

        $data = $this->api_requester->post("access_token", array(
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "app_token"
        ));

        if (isset($data["access_token"])) {
            $this->access_token = $data["access_token"];
            return $this->access_token;
        } else if (isset($data["error"])) {
            throw new WrapItParameterException($data["error"]["message"]);
        }
        throw new WrapItParameterException("Invalid domain or client credentials");
    }

    public function sendPush($userid, $data) {
        $data = $this->push_requester->post("pushservice/$userid", $data);
    }

    public function getPushTemplate() {
        return array(
            "categories" => array(),
            "device_types" => array(
                "mail" => false,
                "sms" => false,
                "browser" => false,
                "phone" => false
            ),
            "properties" => array(
                "attribution" => null,
                "app_icon" => null,
                "hero_image" => null,
                "badge" => null,
                "sound" => array(
                    "UWP" => null,
                    "Apple" => null
                )
            ),
            "title" => null,
            "lines" => array(),
            "actions" => array()
        );
    }

}
