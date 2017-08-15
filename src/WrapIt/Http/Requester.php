<?php

namespace WrapIt\Http;

/**
 * Class Requester
 *
 * @package WrapIt
 */
class Requester
{

    protected function request($data) {
        $data = array_merge(array(
            "url" => null,
            "get" => array(),
            "post" => array(),
            "body_type" => "application/x-www-form-urlencoded",
            "body_charset" => "UTF-8",
            "headers" => array(),
            "response_type" => "json",
            "useragent" => "WrapIt-HTTP/1.0",
            "method" => null
        ), $data);

        if ($data["url"] == null) {
            throw new \WrapIt\Exception\WrapItException("Missing data: url");
        }

        $url = $data["url"];
        if ($data["get"] != null && count($data["get"]) > 0) {
            $url .= "?" . http_build_query($data["get"]);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $data["useragent"]);
        if ($data["post"] != null) {
            $data["headers"][] = "Content-type: ".$data["body_type"];
            $data["headers"][] = "Charset: ".$data["body_charset"];

            switch ($data["body_type"]) {
                case "application/x-www-form-urlencoded":
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data["post"]));
                    break;
                case "application/json":
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data["post"]));
                    break;
                case "text/plain":
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data["post"]);
                    break;
                case "text/xml":
                    if (is_string($data["post"])) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data["post"]);
                    } else {
                        throw new \WrapIt\Exception\WrapItException("XML data must be pre-processed!");
                    }
                    break;
                default:
                    throw new \WrapIt\Exception\WrapItException("Invalid body type");
                    break;
            }

            if ($data["method"] != null) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $data["method"]);
            } else {
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }
        if ($data["headers"] != null && count($data["headers"]) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $data["headers"]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $response_header = curl_getinfo($ch);
        curl_close($ch);

        $this->last_data = array(
            "response_header" => $response_header,
            "raw_result" => $result,
            "input" => $data
        );

        switch ($data["response_type"]) {
            case "json":
                $json = json_decode($result, true);
                if ($json !== null) {
                    return $json;
                } else {
                    return $result;
                }
                break;
            default:
                return $result;
                break;
        }
    }
}
