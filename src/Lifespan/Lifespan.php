<?php

namespace Minhyung\Fss\Lifespan;

use GuzzleHttp\Client;

class Lifespan
{
    const BASE_URI = 'https://www.fss.or.kr/openapi/api/';

    protected $apiKey = '';
    protected $client = null;

    /**
     * @return void
     */
    public function __construct($config)
    {
        $this->apiKey = $config['api_key'];
    }

    /**
     * 연금저축 비교공시 – 회사별 수익률·수수료율
     * 
     * @link   https://www.fss.or.kr/fss/lifeplan/devlopGuide/listInfo1.do?menuNo=201053
     * 
     * @param  int  $year
     * @param  int  $quarter
     * @param  \Minhyung\Fss\Lifespan\PsAreaCode|null $areaCode
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function psCorpList(int $year, int $quarter, ?PsAreaCode $areaCode = null): array
    {
        $params = [];
        $params['year'] = $year;
        $params['quarter'] = $quarter;
        if ($areaCode) {
            $params['areaCode'] = (int)$areaCode;
        }
        return $this->request('psCorpList.json', $params);
    }

    /**
     * 연금저축 비교공시 - 상품별 수익률·수수료율
     * 
     * @link   https://www.fss.or.kr/fss/lifeplan/devlopGuide/listInfo2.do?menuNo=201053
     * 
     * @param  int  $year
     * @param  int  $quarter
     * @param  \Minhyung\Fss\Lifespan\PsAreaCode|null $areaCode
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function psProdList(int $year, int $quarter, ?PsAreaCode $areaCode = null): array
    {
        $params = [];
        $params['year'] = $year;
        $params['quarter'] = $quarter;
        if ($areaCode) {
            $params['areaCode'] = (int)$areaCode;
        }
        return $this->request('psProdList.json', $params);
    }

    /**
     * 연금저축 비교공시 - 원리금보장 연금저축보험
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/listInfo3.do?menuNo=201053
     * 
     * @param  \Minhyung\Fss\Lifespan\PsAreaCode          $areaCode
     * @param  \Minhyung\Fss\Lifespan\PsChannelCode|null  $channelCode
     */
    public function psGuaranteedProdList(PsAreaCode $areaCode, ?PsChannelCode $channelCode = null): array
    {
        $params = [];
        $params['areaCode'] = (int)$areaCode;
        if ($channelCode) {
            $params['channelCode'] = (int)$channelCode;
        }
        return $this->request('psGuaranteedProdList.json', $params);
    }

    /**
     * @param  string $uri
     * @param  array  $params
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function request(string $uri, array $params = []): array
    {
        $requestOptions = [
            'query' => $params + ['key' => $this->apiKey],
        ];

        $response = $this->httpClient()->get($uri, $requestOptions);
        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody, true);

        if ($responseData['code'] != ResponseCode::SUCCEEDED) {
            throw new ApiException($responseData['code'], $responseData['message']);
        }
        return $responseData['list'];
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function httpClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client([
                'base_uri' => static::BASE_URI,
            ]);
        }
        return $this->client;
    }
}
