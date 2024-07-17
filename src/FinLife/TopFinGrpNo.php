<?php

namespace Minhyung\Fss\FinLife;

/**
 * 권역 코드
 */
enum TopFinGrpNo: string
{
    // 은행
    case BANK = '020000';
    // 여신전문
    case CREDIT_FINANCE = '030200';
    // 저축은행
    case SAVING_BANK = '030300';
    // 보험
    case INSURANCE = '050000';
    // 금융투자
    case FINANCIAL_INVESTMENT = '060000';
}
