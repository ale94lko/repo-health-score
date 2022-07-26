<?php

class Request
{
    const URL = 'https://api.github.com/repos/';
    const DEFAULT_URL_PARAM = '/community/profile';
    const USER_AGENT = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';

    private string $repository;
    private string $healthPercentage;

    /**
     * @param string $repository
     */
    public function __construct(string $repository)
    {
        $this->repository = $repository;
        $this->healthPercentage = 'Error on params';
    }

    /**
     * @return string
     */
    public function generateUrl(): string
    {
        return self::URL . $this->repository . self::DEFAULT_URL_PARAM;
    }

    /**
     * @return string
     */
    public function getHealthPercentage(): string
    {
        $healthPercentage = $this->healthPercentage;

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $this->generateUrl());
        curl_setopt($curl,CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($curl,CURLOPT_HEADER,true);
        curl_setopt($curl,CURLOPT_HEADER, 'Accept: application/vnd.github+json');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (isset($result['health_percentage'])) {
            $healthPercentage = $result['health_percentage'];
        }

        return $healthPercentage;
    }
}