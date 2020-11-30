<?php

declare(strict_types=1);

namespace DnsMadeEasy\Interfaces\Models;

/**
 * Represents a Vanity NameServer resource.
 *
 * @package DnsMadeEasy\Interfaces
 *
 * @property int $nameServerGroupId
 * @property string $nameServerGroup
 * @property bool $default
 * @property string[] $servers
 * @property-read bool $public
 * @property string $name
 * @property-read int $accountId
 */
interface VanityNameServerInterface extends AbstractModelInterface
{
}