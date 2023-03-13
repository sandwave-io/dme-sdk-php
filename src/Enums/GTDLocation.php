<?php

declare(strict_types = 1);

namespace DnsMadeEasy\Enums;

/**
 * Enums to represent Global Traffic Director locations.
 *
 * @package DnsMadeEasy\Enums
 */
enum GTDLocation: string
{
    case DEFAULT = 'DEFAULT';
    case US_EAST = 'US_EAST';
    case US_WEST = 'US_WEST';
    case EUROPE = 'EUROPE';
    case ASIA_PAC = 'ASIA_PAC';
    case OCEANIA = 'OCEANIA';
}
