<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
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
