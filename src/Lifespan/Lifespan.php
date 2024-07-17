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
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
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
     * 퇴직연금 비교공시 – 수익률 (단위: 조원)
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list3Info1.do?menuNo=201055
     * 
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function pensionStat()
    {
        return $this->request('pensionStat.json');
    }

    /**
     * 연금 통계 - 공적연금 통계 (단위: 조원)
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list3Info2.do?menuNo=201055
     * 
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function publicPensionStat()
    {
        return $this->request('publicPensionStat.json');
    }

    /**
     * 연금 통계 - 개인연금 통계 (단위: 조원)
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list3Info3.do?menuNo=201055
     * 
     * @param  int  $stateType  통계 종류 (1: 개인연금 적립금, 2: 연금저축 적립금, 3: 연금저축 계약건수)
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function personalPensionStat(int $statType): array
    {
        $params = [];
        $params['statType'] = $statType;
        return $this->request('personalPensionStat.json', $params);
    }

    /**
     * 연금 통계 - 퇴직연금 통계 (단위: 조원)
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list3Info4.do?menuNo=201055
     * 
     * @param  int  $stateType  통계 종류 (1: 퇴직연금 적립금, 3: 퇴직연금 계약건수)
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function retirementPensionStat(int $statType): array
    {
        $params = [];
        $params['statType'] = $statType;
        return $this->request('retirementPensionStat.json', $params);
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
