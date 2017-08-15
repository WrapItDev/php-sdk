<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItApiRequester;

/**
 * Class WrapItUserHelper
 *
 * @package WrapIt
 */
class WrapItUserHelper {

    private $access_token = null;

    private $client_id = null;
    private $client_secret = null;

    private $requester;

    public function __construct($wi, $access_token) {
        if (!($wi instanceof WrapIt)) {
            throw new WrapItParameterException("WrapIt class required");
        }

        $this->client_id = $wi->getClientId();
        $this->client_secret = $wi->getClientSecret();
        $this->access_token = $access_token;
        $this->requester = new WrapItUserRequester($wi->getDomain(), $access_token);
    }

    public function getUserData($userid = "me") {
        return $this->requester->get("people/$userid");
    }

}
