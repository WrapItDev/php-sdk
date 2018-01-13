<?php

namespace WrapIt\Helpers;

use WrapIt\WrapIt;
use WrapIt\Exceptions\WrapItParameterException;
use WrapIt\Exceptions\WrapItResponseException;
use WrapIt\Http\WrapItApiRequester;

/**
 * Class Helper
 *
 * @package WrapIt
 */
abstract class WrapItApiHelper {

    protected $client_id = null;
    protected $client_secret = null;

    protected $api_requester;

    public function __construct($wi) {
        if (!($wi instanceof WrapIt)) {
            throw new WrapItParameterException("WrapIt class required");
        }

        $this->client_id = $wi->getClientId();
        $this->client_secret = $wi->getClientSecret();
        $this->api_requester = new WrapItApiRequester($wi->getDomain());
    }
}
