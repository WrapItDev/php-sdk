<?php

namespace WrapIt;

use \WrapIt\Exception\WrapItParameterException;
use \WrapIt\Exception\WrapItServerException;
use \WrapIt\Exception\WrapItResponseException;

class WrapIt {

    private $server_uri;

    private $sdk_version = "0.1";
    private $access_token = null;
    private $public_key = null;
    private $private_key = null;

    public function __construct($config) {
        $this->config = array_merge(array(
            "domain" => null,
            "client_id" => null,
            "client_secret" => null,
            "access_token" => null
        ), $config);

        if ($this->config["domain"] == null) {
            throw new WrapItParameterException("config[domain] is required but missing");
        }

        if ($this->config["client_id"] == null) {
            throw new WrapItParameterException("config[client_id] is required but missing");
        }

        if ($this->config["client_secret"] == null) {
            throw new WrapItParameterException("config[client_secret] is required but missing");
        }

        $this->config["domain"] = str_replace("https://", "", $this->config["domain"]);
        $this->config["domain"] = str_replace("http://", "", $this->config["domain"]);
        $this->config["domain"] = rtrim($this->config["domain"], "/");
        $this->server_uri = "https://".$this->config["domain"];

        $this->public_key = $this->config["client_id"];
        $this->private_key = $this->config["client_secret"];
    }

    private function request($api, $post) {
        $api = ltrim($api, "/");

        $url = $this->server_uri."/".$api;

        if ($this->public_key != null && $this->private_key != null) {
            if ($post == null) {
                $post = array();
            }
            $post["client_id"] = $this->public_key;
            $post["client_secret"] = $this->private_key;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SDK/PHP.'.$this->sdk_version);
        if ($this->access_token != null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->access_token));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($post != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_POST, true);
        }
        $result = curl_exec($ch);
        $response_header = curl_getinfo($ch);
        curl_close($ch);

        $data = json_decode($result, true);
        if ($data !== null) {
            return $data;
        } else {
            throw new WrapItServerException("Not valid JSON (".$url."): ".$result."");
        }
    }

    public function getAccessToken() {
        if ($this->access_token == null) {
            throw new WrapItParameterException("Access token not set");
        }
        return $this->access_token;
    }

    public function generateLoginUrl($redirect_uri, $scopes, $state = null) {
        if ($this->public_key == null) {
            throw new WrapItParameterException("Public key not set");
        }

        $arr = array(
            "client_id" => $this->public_key,
            "redirect_uri" => $redirect_uri,
            "scope" => implode(" ", $scopes),
            "response_type" => "code"
        );

        if ($state != null) {
            $arr["state"] = $state;
        }

        return $this->server_uri."/auth?".http_build_query($arr);
    }

    public function exchangeAccessToken($redirect_uri, $code, $expire = null) {
        if ($this->public_key == null) {
            throw new WrapItParameterException("Public key not set");
        }

        $post = array(
            "client_id" => $this->public_key,
            "client_secret" => $this->private_key,
            "grant_type" => "client_credentials",
            "redirect_uri" => $redirect_uri,
            "code" => $code
        );

        if ($expire != null) {
            $post["expire"] = $expire;
        }

        $data = $this->request("access_token", $post);
        if (!isset($data["error"]) && isset($data["access_token"])) {
            $this->access_token = $data["access_token"];
            return $data["access_token"];
        } else if (isset($data["error"])) {
            throw new WrapItResponseException($data["error"]["message"]);
        } else {
            throw new WrapItResponseException("Unknown error");
        }
    }

    public function getUserData($userid = "me") {
        if ($this->access_token == null) {
            throw new WrapItParameterException("Access token not set");
        }
        return $this->request("people/".$userid, null);
    }

    public function get($api) {
        return $this->request($api, null);
    }

    public function post($api, $postdata) {
        return $this->request($api, $postdata);
    }

}

?>
