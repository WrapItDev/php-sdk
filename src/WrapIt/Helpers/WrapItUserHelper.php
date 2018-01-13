<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItUserRequester;
use WrapIt\Helpers\Helper;

/**
 * Class WrapItUserHelper
 *
 * @package WrapIt
 */
class WrapItUserHelper extends Helper {

    protected $access_token = null;
    protected $user_requester;

    public function __construct($wi, $access_token) {
        parent::__construct($wi);

        $this->access_token = $access_token;
        $this->user_requester = new WrapItUserRequester($this->domain, $access_token);
    }

    public function getUserData($userid = "me") {
        $data = $this->user_requester->get("people/$userid");
        if ($data != null && !isset($data["error"])) {
            return $data;
        } else {
            throw new WrapItResponseException($data["error"]["message"]);
        }
    }

    public function getProfilePicture($userid = "me") {
        $data = $this->user_requester->get("people/$userid/picture", array("redirect" => "false"));
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
