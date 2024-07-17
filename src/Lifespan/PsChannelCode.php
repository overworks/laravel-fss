<?php

namespace Minhyung\Fss\Lifespan;

/**
 * 연금저축 가입자 구분
 * 
 * @link  https://www.fss.or.kr/fss/lifeplan/devlopGuide/listInfo3.do?menuNo=201053
 */
enum PsChannelCode: int
{
    case COMPANY = 1;   // 설계사
    case AGENCY = 3;    // 대리점
    case ONLINE = 4;    // 온라인
}
