<?php

namespace WrapIt\Http;

class WrapItApiRequester extends Requester {

    private $domain = null;

    function __construct($domain) {
        $this->domain = $domain;
    }

    public function get($api, $data = array()) {
        $api = ltrim("/", $api);
        return $this->request(array(
            "url" => "https://" . $this->domain . "/" . $api,
            "get" => $data
        ));
    }

    public function post($api, $data) {
        $api = ltrim("/", $api);
        return $this->request(array(
            "url" => "https://" . $this->domain . "/" . $api,
            "post" => $data
        ));
    }

    public function getDomain() {
        return $this->domain;
    }

}

?>
