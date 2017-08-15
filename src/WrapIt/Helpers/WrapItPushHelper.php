<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItApiRequester;
use WrapIt\Http\WrapItPushRequester;

/**
 * Class WrapItUserHelper
 *
 * @package WrapIt
 */
class WrapItPushHelper {

    private $access_token = null;

    private $client_id = null;
    private $client_secret = null;
    private $domain = null;

    private $requester;

    public function __construct($wi, $access_token = null) {
        if (!($wi instanceof WrapIt)) {
            throw new WrapItParameterException("WrapIt class required");
        }

        $this->client_id = $wi->getClientId();
        $this->client_secret = $wi->getClientSecret();
        $this->access_token = $access_token;
        $this->domain = $wi->getDomain();
        $this->requester = new WrapItPushRequester($this->domain, $this->getAccessToken());
    }

    private function getAccessToken() {
        if ($this->access_token != null) {
            return $this->access_token;
        }

        $apirequester = new WrapItApiRequester($this->domain);

        $data = $apirequester->post("access_token", array(
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "app_token"
        ));

        if (isset($data["access_token"])) {
            $this->access_token = $data["access_token"];
            return $this->access_token;
        }
        throw new WrapItParameterException("Invalid domain or client credentials");
    }

    public function sendPush($userid, $data) {
        $data = $this->requester->post("pushservice/$userid", $data);
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
