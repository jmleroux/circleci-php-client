<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
interface ModelInterface
{
    /**
     * Create a model from a decoded JSON array
     *
     * @param array $decodedValues
     *
     * @return ModelInterface
     */
    public static function createFromNormalized(array $decodedValues);

    /**
     * Returns JSON representation of the model
     *
     * @return string
     */
    public function toJson(): string;

    /**
     * Returns array representation of the model
     *
     * @return array
     */
    public function normalize(): array;
}
