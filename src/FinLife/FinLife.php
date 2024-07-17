<?php

namespace Minhyung\Fss\FinLife;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class FinLife
{
    const BASE_URI = 'http://finlife.fss.or.kr/finlifeapi/';

    protected string $apiKey = '';
    protected ?Client $client = null;

    /**
     * @param  array  $config
     * @return void
     */
    public function __construct($config)
    {
        $this->apiKey = $config['api_key'];
    }

    /**
     * @return bool
     */
    public function isApiKeyEmpty(): bool
    {
        return empty($this->apiKey);
    }

    /**
     * @param  Api          $api
     * @param  TopFinGrpNo  $topFinGrpNo
     * @param  int          $pageNo
     * @param  string|null  $financeCd
     * @throws \Minhyung\Fss\FinLife\ApiException
     * @return array
     */
    public function request(Api $api, TopFinGrpNo $topFinGrpNo, int $pageNo = 1, ?string $financeCd = null): array
    {
        $uri = $api->value.'Search.json';
        $params = [
            'auth' => $this->apiKey,
            'topFinGrpNo' => $topFinGrpNo->value,
            'pageNo' => $pageNo,
        ];
        if ($financeCd) {
            $params['financeCd'] = $financeCd;
        }
        
        $requestOptions = [RequestOptions::QUERY => $params];

        $response = $this->httpClient()->get($uri, $requestOptions);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody, true);

        $result = $responseData['result'];
        if ($result['err_cd'] != '000') {
            throw new ApiException($result['err_cd'], $result['err_msg']);
        }
        return $result;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function httpClient(): Client
    {
        if (is_null($this->client)) {
            $this->client = new Client([
                'base_uri' => static::BASE_URI,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
        return $this->client;
    }
}
