<?php

use Minhyung\Fss\FinLife\Api;
use Minhyung\Fss\FinLife\TopFinGrpNo;

if (! function_exists('fss_finlife')) {

    /**
     * 금융상품한눈에 API 호출
     * 
     * @param  Api          $api
     * @param  TopFinGrpNo  $topFinGrpNo
     * @param  int          $pageNo
     * @param  string|null  $financeCd
     * @throws \Minhyung\Fss\FinLife\ApiException
     * @return array
     */
    function fss_finlife(Api $api, TopFinGrpNo $topFinGrpNo, int $pageNo = 1, ?string $financeCd = null)
    {
        return app('fss.finlife')->request($api, $topFinGrpNo, $pageNo, $financeCd);
    }
}

if (! function_exists('fss_lifespan')) {

    /**
     * 통합연금포털 API 서비스 컨테이터 취득
     * 
     * @return  \Minhyung\Fss\Lifespan
     */
    function fss_lifespan()
    {
        return app('fss.lifespan');
    }
}
