<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItUserRequester;

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
        $data = $this->requester->get("people/$userid");
        if (!isset($data["error"])) {
            return $data;
        } else {
            throw new WrapItResponseException($data["error"]["message"]);
        }
    }

    public function getProfilePicture($userid = "me") {
        $data = $this->requester->get("people/$userid/picture", array("redirect" => "false"));
        if (isset($data["error"])) {
            throw new WrapItResponseException($data["error"]["message"]);
        }

        if (isset($data["url"])) {
            return $data["url"];
        } else {
            throw new WrapItResponseException("Unknown Exception");
        }
    }

}
