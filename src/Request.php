<?php

declare(strict_types=1);

class Request
{
    private const URL = 'https://api.github.com/repos/';
    private const DEFAULT_URL_PARAM = '/community/profile';
    private const USER_AGENT = 'repo-health-score';

    private string $repository;
    private string $token;

    public function __construct(string $repository, string $token = '')
    {
        $this->repository = $repository;
        $this->token = $token;
    }

    public function generateUrl(): string
    {
        return self::URL . $this->repository . self::DEFAULT_URL_PARAM;
    }

    public function getHealthPercentage(): string
    {
        if ($this->repository === '') {
            return 'n/a';
        }

        $headers = [
            'Accept: application/vnd.github+json',
            'User-Agent: ' . self::USER_AGENT,
            'X-GitHub-Api-Version: 2022-11-28',
        ];

        if ($this->token !== '') {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->generateUrl(),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);
        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false || $statusCode < 200 || $statusCode >= 300) {
            return 'error';
        }

        $result = json_decode($response, true);

        if (!is_array($result) || !isset($result['health_percentage'])) {
            return 'error';
        }

        return ((int) $result['health_percentage']) . '%';
    }
}
