<?php

namespace Minhyung\Fss\Lifespan;

enum ResponseCode: string
{
    case SUCCEEDED = '000';
    case EMPTY = '001';

    case INVALID_KEY = '100';
    case RATE_LIMIT_EXCEEDED = '101';
    case INVALID_IP = '102';

    case INVALID_SERVICE = '200';

    case SERVER_ERROR = '500';
    case SERVER_NOT_RESPONDED = '501';

    case NOT_AUTHORIZED = '600';

    case INVALID_PARAMETERS = '700';

    case UNDEFINED_ERROR = '900';
}
