<?php
declare(strict_types=1);

namespace DnsMadeEasy\Enums;

use Spatie\Enum\Enum;

/**
 * Enums to represent record types
 * @package DnsMadeEasy\Enums
 *
 * @method static self A()
 * @method static self AAAA()
 * @method static self ANAME()
 * @method static self CNAME()
 * @method static self HTTPRED()
 * @method static self MX()
 * @method static self NS()
 * @method static self PTR()
 * @method static self SRV()
 * @method static self TXT()
 * @method static self SPF()
 * @method static self SOA()
 */
class RecordType extends Enum
{

}