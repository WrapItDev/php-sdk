<?php

namespace WrapIt\Helpers;

use \WrapIt\Exception\WrapItParameterException;
use \WrapIt\Exception\WrapItResponseException;
use \WrapIt\Http\WrapItApiRequester;

/**
 * Class WrapItLoginHelper
 *
 * @package WrapIt
 */
class WrapItLoginHelper
{

    private $access_token = null;
    private $client_id = null;
    private $client_secret = null;

    private $requester;

    public function __construct($client_id, $client_secret, $requester)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->requester = $requester;
    }

    public function generateLoginUrl($opt)
    {
        $opt = array_merge(array(
            "redirect_uri" => null,
            "scope" => array("profile"),
            "response_type" => "code",
            "state" => null
        ), $opt);

        if ($opt["redirect_uri"] == null) {
            throw new WrapItParameterException("redirect_uri is missing");
        }

        $parameters = array(
            "client_id" => $this->client_id,
            "redirect_uri" => $opt["redirect_uri"],
            "scope" => implode(" ", $opt["scope"]),
            "response_type" => $opt["state"]
        );

        if ($opt["state"] != null) {
            $parameters["state"] = $opt["state"];
        }

        return "https://" . $this->requester->getDomain() . "/auth?" . http_build_query($parameters);
    }

    public function exchangeAccessToken($opt)
    {
        $opt = array_merge(array(
            "redirect_uri" => null,
            "code" => null,
            "expire" => null
        ), $opt);

        if ($opt["redirect_uri"] == null) {
            throw new WrapItParameterException("redirect_uri is missing");
        }
        if ($opt["code"] == null) {
            throw new WrapItParameterException("code is missing");
        }

        $post = array(
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "client_credentials",
            "redirect_uri" => $opt["redirect_uri"],
            "code" => $opt["code"]
        );

        if ($opt["expire"] != null) {
            $post["expire"] = $opt["expire"];
        }

        $data = $this->requester->post("access_token", $post);

        if (!isset($data["error"]) && isset($data["access_token"])) {
            $this->access_token = $data["access_token"];
            return $data["access_token"];
        } else if (isset($data["error"])) {
            throw new WrapItResponseException($data["error"]["message"]);
        } else {
            throw new WrapItResponseException("Unknown error");
        }
    }
}
