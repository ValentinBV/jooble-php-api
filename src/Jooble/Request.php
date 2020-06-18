<?php

namespace valentinbv\Jooble;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use valentinbv\Jooble\Exception\JoobleRequestException;

class Request
{
    /**
     * Jooble api url
     * @var string
     */
    private $apiUrl = 'https://ru.jooble.org/api/';
    /**
     * Your Jooble api access token
     * @var string
     */
    private $accessToken = '';
    /**
     * GuzzleHttp Client object
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * Jooble php api constructor
     * @param ClientInterface $httpClient
     * @param string $apiUrl
     */
    public function __construct(ClientInterface $httpClient, string $apiUrl = '')
    {
        if ($apiUrl) {
            $this->$apiUrl = $apiUrl;
        }
        $this->httpClient = $httpClient;
    }

    /**
     * Allows to search job by params
     * @param array $params
     *      - string keywords: (required) - search keywords
     *      - string location: Location
     *      - integer radius: distance (0, 5, 10, 15, 25, 50) kilometer
     *      - integer salary: salary range
     *      - integer page: page number
     *      - integer searchMode: Job listings display mode
     *          1 - Recommended job listings + *JDP (Jooble Job Description mode for a better user experience)
     *          2 - Recommended job listings
     *          3 - All job listings (not recommended)
     * @return array
     * @throws JoobleRequestException
     */
    public function search(array $params = []): array
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->apiUrl . $this->accessToken,
                ['json' => $params]
            );
        } catch (TransferException $e) {
            throw new JoobleRequestException($e);
        }
        return $this->decodeBody($response->getBody()->getContents());
    }

    /**
     * Set your jooble api access token
     * @param string $token
     */
    public function setAccessToken(string $token)
    {
        $this->accessToken = $token;
    }

    /**
     * Get your jooble api access token $accessToken
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}