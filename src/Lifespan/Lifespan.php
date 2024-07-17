<?php

namespace Minhyung\Fss\Lifespan;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Lifespan
{
    const BASE_URI = 'https://www.fss.or.kr/openapi/api/';

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
     * 연금저축 비교공시 – 회사별 수익률·수수료율
     * 
     * @link   https://www.fss.or.kr/fss/lifeplan/devlopGuide/listInfo1.do?menuNo=201053
     * 
     * @param  int  $year    연도 (YYYY)
     * @param  int  $quarter 분기 (1~4)
     * @param  \Minhyung\Fss\Lifespan\AreaCode|null $areaCode  권역
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function psCorpList(int $year, int $quarter, ?AreaCode $areaCode = null): array
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
     * @param  int  $year     연도 (YYYY)
     * @param  int  $quarter  분기 (1~4)
     * @param  \Minhyung\Fss\Lifespan\AreaCode|null $areaCode  권역
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function psProdList(int $year, int $quarter, ?AreaCode $areaCode = null): array
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
     * @param  \Minhyung\Fss\Lifespan\AreaCode          $areaCode
     * @param  \Minhyung\Fss\Lifespan\PsChannelCode|null  $channelCode
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function psGuaranteedProdList(AreaCode $areaCode, ?PsChannelCode $channelCode = null): array
    {
        $params = [];
        $params['areaCode'] = (int)$areaCode;
        if ($channelCode) {
            $params['channelCode'] = (int)$channelCode;
        }
        return $this->request('psGuaranteedProdList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 – 수익률
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list2Info1.do?menuNo=201054
     * 
     * @param  int      $year    연도 (YYYY)
     * @param  int      $quarter 분기 (1~4)
     * @param  int|null $sysType 권역 (1: 원리금 보장, 2: 원리금 비보장, 3: 합계, 4: 자사계열사, 5: 기타사업자)
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function rpCorpResultList(int $year, int $quarter, ?int $sysType = null): array
    {
        $params = [];
        $params['year'] = $year;
        $params['quarter'] = $quarter;
        if ($sysType) {
            $params['sysType'] = $sysType;
        }
        return $this->request('rpCorpResultList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 – 총비용 부담률
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list2Info2.do?menuNo=201054
     * 
     * @param  int  $year  연도 (YYYY)
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function rpCorpBurdenRatioList(int $year): array
    {
        $params = [];
        $params['year'] = $year;
        return $this->request('rpCorpBurdenRatioList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 - 맞춤형 수수료 비교
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list2Info3.do?menuNo=201054
     * 
     * @param  int      $reserve  적립금액 (백만 단위 입력)
     * @param  int|null $sysType  제도 유형(1: DB, 2: DC, 3: 기업형 IRP, 4: 개인형 IRP(가입자 부담분), 5: 표준형 DC, 6: 연금전환특약, 7: 개인형 IRP(사용자 부담분))
     * @param  int|null $term     장기 계약
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function rpCorpCustomFeeList(int $reserve, ?int $sysType = null, ?int $term = null): array
    {
        $params = [];
        $params['reserve'] = $reserve;
        if ($sysType) {
            $params['sysType'] = $sysType;
        }
        if ($term) {
            $params['term'] = $term;
        }
        return $this->request('rpCorpCustomFeeList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 - 원리금보장상품 제공현황
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list2Info4.do?menuNo=201054
     * 
     * @param  \Minhyung\Fss\Lifespan\AreaCode|null $areaCode  권역
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function rpGuaranteedProdSupplyList(?AreaCode $areaCode = null): array
    {
        $params = [];
        if ($areaCode) {
            $params['areaCode'] = (int)$areaCode;
        }
        return $this->request('rpGuaranteedProdSupplyList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 - 원리금보장 퇴직연금상품
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list2Info5.do?menuNo=201054
     * 
     * @param  \Minhyung\Fss\Lifespan\AreaCode  $areaCode  권역
     * @param  int       $sysType     제도 유형 (1: DB, 2: DC, 3: IRP)
     * @param  int       $reportYear  기준 시점 연도 (YYYY)
     * @param  int       $reportMonth 기준 시점 달 (1~12)
     * @param  int|null  $productType 상품 유형 (1: 은행 예적금, 2: 저축은행 예적금, 3: 우체국 예적금, 4: 금리연동형 보험, 5: 이율보증형 보험, 6: 정부보증채, 7: 원리금파생상품결합사채, 8: 환매조건부 매수계약)
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function rpGuaranteedProdList(AreaCode $areaCode, int $sysType, int $reportYear, int $reportMonth, ?int $productType = null): array
    {
        $params = [];
        $params['areaCode'] = (int)$areaCode;
        $params['sysType'] = $sysType;
        $params['reportDate'] = (new DateTime())->setDate($reportYear, $reportMonth, 1)->format('Y/m');
        if ($productType) {
            $params['productType'] = $productType;
        }
        return $this->request('rpGuaranteedProdList.json', $params);
    }

    /**
     * 퇴직연금 비교공시 – 수익률 (단위: 조원)
     * 
     * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/list3Info1.do?menuNo=201055
     * 
     * @throws \Minhyung\Fss\Lifespan\ApiException
     * @return array
     */
    public function pensionStat(): array
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
    public function publicPensionStat(): array
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
            RequestOptions::QUERY => $params + ['key' => $this->apiKey],
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
