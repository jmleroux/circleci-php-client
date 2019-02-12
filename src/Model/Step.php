<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Step
{
    /** @var string */
    public $name;
    /** @var string[] */
    public $actions = [];

    private function __construct(string $name, array $actions)
    {
        Assert::notEmpty($name);

        $this->name = $name;
        $this->actions = $actions;
    }

    public static function createFromArray(array $values): Step
    {
        Assert::keyExists($values, 'name');
        Assert::keyExists($values, 'actions');

        $actions = array_map(function (array $action) {
            return $action['start_time'];
        }, $values['actions']);

        return new self(
            $values['name'],
            $actions
        );
    }

    public function normalize(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
