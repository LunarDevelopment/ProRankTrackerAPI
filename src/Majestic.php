<?php

namespace LunarDevelopment\Majestic;

/**
 * Class Majestic
 *
 * @package LunarDevelopment\Majestic
 *
 *  Use this class to communicate with Majestic Live and Sandbox URLs
 *
 *  @author LunarDevelopment
 */
class Majestic
{

    /**
     * @var string
     */
    private $endpoint = "http://enterprise.majestic.com/api";

    /**
     * Majestic constructor.
     * @param      $apiKey
     * @param bool $sandbox
     */
    public function __construct($apiKey, $sandbox = false)
    {
        if ($sandbox == true) {
            $this->endpoint = "http://developer.majestic.com/api";
        }
        $this->responseType = "json";
        $this->apiKey = $apiKey;
    }

    /**
     * @param $type
     */
    public function setResponseType($type)
    {
        $this->responseType = $type;
    }

    /**
     * @param       $command
     * @param array $params
     * @return mixed
     */
    public function executeCommand($command, $params = array())
    {
        $client = new Client;
        $params["cmd"] = $command;
        $params["app_api_key"] = $this->apiKey;
        return $client->get($this->endpoint . "/" . $this->responseType, [
            'query' => $params
        ]);
    }
}