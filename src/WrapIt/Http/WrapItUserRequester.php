<?php

namespace WrapIt\Http;

/**
 * Class WrapItApiRequester
 *
 * @package WrapIt
 */
class WrapItUserRequester extends Requester {

    private $access_token = null;

    public function __construct($domain, $token) {
        $this->domain = $domain;
        $this->access_token = $token;
    }

    public function get($api, $data = array()) {
        $api = ltrim($api, "/");
        return $this->request(array(
            "url" => "https://" . $this->domain . "/" . $api,
            "get" => $data,
            "headers" => array(
                "Authorization: Bearer ".$this->access_token
            )
        ));
    }

    public function post($api, $data) {
        $api = ltrim($api, "/");
        return $this->request(array(
            "url" => "https://" . $this->domain . "/" . $api,
            "post" => $data,
            "headers" => array(
                "Authorization: Bearer ".$this->access_token
            )
        ));
    }

}
