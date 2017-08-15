<?php

namespace WrapIt;

use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Http\WrapItApiRequester;
use WrapIt\Helpers\WrapItLoginHelper;

/**
 * Class WrapIt
 *
 * @package WrapIt
 */
class WrapIt
{

    private $config;

    private $server_uri;

    private $sdk_version = "0.1";
    private $public_key = null;
    private $private_key = null;

    private $requester = null;

    public function __construct($config)
    {
        $this->config = array_merge(array(
            "domain" => null,
            "client_id" => null,
            "client_secret" => null
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

        $this->requester = new WrapItApiRequester($this->config["domain"]);
    }

    public function getLoginHelper()
    {
        if ($this->public_key == null) {
            throw new WrapItParameterException("Public key not set");
        }
        $helper = new WrapItLoginHelper($this->public_key, $this->private_key, $this->requester);
    }

    public function getClientId()
    {
        return $this->public_key;
    }
}
