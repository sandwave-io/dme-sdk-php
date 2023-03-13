<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Enums;

/**
 * Enums to represent record types.
 *
 * @package DnsMadeEasy\Enums
 */
enum RecordType: string
{
    case A = 'A';
    case AAAA = 'AAAA';
    case ANAME = 'ANAME';
    case CNAME = 'CNAME';
    case HTTPRED = 'HTTPRED';
    case MX = 'MX';
    case NS = 'NS';
    case PTR = 'PTR';
    case SRV = 'SRV';
    case TXT = 'TXT';
    case SPF = 'SPF';
    case SOA = 'SOA';
}
