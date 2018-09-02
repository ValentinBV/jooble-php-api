<?php

namespace Sibdev\Jooble;

use GuzzleHttp\Client;

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
     * @var Client 
     */
    private $httpClient;
    /**
     * Results Total Count
     * @var integer 
     */
    private $totalCount = 0;
    
    /**
     * Jooble php api constructor
     */
    public function __construct()
    {
        $this->httpClient = new Client();
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
     *          1 - Recommended job listngs + *JDP (Jooble Job Description mode for a better user experience)
     *          2 - Recommended job listings
     *          3 - All job listings (not recommended)
     * @return array
     * @throws \Exception
     */
    public function search(array $params = [])
    {   
        $resultJson = $this->httpClient->request('POST', $this->apiUrl . $this->accessToken, ['json' => $params]);
        $resultArray = \GuzzleHttp\json_decode($resultJson->getBody(), true);
        if (array_key_exists('totalCount', $resultArray)) {
            $this->totalCount = $resultArray['totalCount'];
        }
        
        return $resultArray['jobs'] ? : [];
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
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    
    /**
     * Set jooble api url
     * @param string $url
     */
    public function setApiUrl(string $url)
    {
        $this->apiUrl = $url;
    }
    
    /**
     * Return current jobble api url
     * @return string $apiUrl
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }
    
    /**
     * Get results total count
     * @return integer
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
}