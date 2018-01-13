<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItApiRequester;

/**
 * Class WrapItApiHelper
 *
 * @package WrapIt
 */
class WrapItApiHelper {

    private $client_id = null;
    private $client_secret = null;

    private $requester;

    public function __construct($wi) {
        if (!($wi instanceof WrapIt)) {
            throw new WrapItParameterException("WrapIt class required");
        }

        $this->client_id = $wi->getClientId();
        $this->client_secret = $wi->getClientSecret();
        $this->requester = new WrapItApiRequester($wi->getDomain());
    }

    public function request($api, $data) {
        return $this->requester->post($api, array_merge([
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ], $data));
    }
}
