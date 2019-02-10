<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
interface ModelInterface
{
    /**
     * Create a model form a JSON string
     *
     * @param string $json
     *
     * @return ModelInterface
     */
    public static function createFromJson(string $json);

    /**
     * Retrun JSON representation of the model
     *
     * @return string
     */
    public function toJson(): string;
}
