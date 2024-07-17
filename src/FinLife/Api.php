<?php

namespace Minhyung\Fss\FinLife;

enum Api: string
{
    case COMPANY = 'company';
    case DEPOSIT = 'depositProducts';
    case SAVING = 'savingProducts';
    case ANNUITY_SAVING = 'annuitySavingProducts';
    case MORTGAGE_LOAN = 'mortgageLoanProducts';
    case RENT_HOUSE_LOAN = 'rentHouseLoanProducts';
    case CREDIT_LOAN = 'creditLoanProducts';
}
