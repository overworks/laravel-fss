<?php

namespace Minhyung\Fss\Lifespan;

/**
 * 연금저축 권역 코드
 */
enum AreaCode: int
{
    case BANK = 1;
    case STOCK = 2;
    case ASSET_MANAGEMENT = 3;
    case LIFE_INSURANCE = 4;
    case NONE_LIFE_INSURANCE = 5;
}
