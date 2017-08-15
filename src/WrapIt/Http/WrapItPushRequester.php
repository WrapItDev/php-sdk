<?php

namespace WrapIt\Http;

use WrapIt\Exceptions\WrapItParameterException;

/**
 * Class WrapItPushRequester
 *
 * @package WrapIt
 */
class WrapItPushRequester extends Requester {

    private $access_token = null;

    public function __construct($domain, $token) {
        $this->domain = $domain;
        $this->access_token = $token;
    }

    public function get($api, $data = array()) {
        throw new WrapItParameterException("GET not alowed with this requester");
    }

    public function post($api, $data) {
        $api = ltrim("/", $api);
        return $this->request(array(
            "url" => "https://" . $this->domain . "/" . $api,
            "post" => $data,
            "body_type" => "applicaton/json",
            "headers" => array(
                "Authorization: Bearer ".$this->access_token
            )
        ));
    }

}
