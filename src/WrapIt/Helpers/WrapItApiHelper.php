<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItApiRequester;
use WrapIt\Helpers\Helper;

/**
 * Class WrapItApiHelper
 *
 * @package WrapIt
 */
class WrapItApiHelper extends Helper {

    public function __construct($wi) {
        parent::__construct($wi);
    }

    public function request($api, $data) {
        return $this->api_requester->post($api, array_merge([
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ], $data));
    }
}
