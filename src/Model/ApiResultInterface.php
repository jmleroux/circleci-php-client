<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * A model implementing ApiResultInterface can be created from the API json result and can return this raw results.
 * This way you are free to use the provided properties, to use your own properties or to use directly the raw values.
 *
 * @author  JM Leroux <jmleroux.pro@gmail.com>
 */
interface ApiResultInterface
{
    /**
     * @return self (type hinting will be allowed in PHP 7.4
     */
    public static function createFromApi(\stdClass $rawObject);

    /**
     * @return \stdClass: Raw object from Circle CI API
     */
    public function rawValues(): \stdClass;
}
