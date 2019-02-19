<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Model;

use Webmozart\Assert\Assert;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 */
class Project implements ModelInterface
{
    /** @var string */
    private $vcsUrl;
    /** @var bool */
    private $followed = false;
    /** @var string */
    private $username;
    /** @var string */
    private $reponame;
    /** @var string[] */
    private $branches = [];

    private function __construct(string $vcsUrl, bool $followed, string $username, string $reponame, array $branches)
    {
        Assert::notEmpty($vcsUrl);
        Assert::notEmpty($reponame);

        $this->vcsUrl = $vcsUrl;
        $this->followed = $followed;
        $this->username = $username;
        $this->reponame = $reponame;
        $this->branches = $branches;
    }

    public static function createFromNormalized(array $decodedValues): Project
    {
        $project = new self(
            $decodedValues['vcs_url'],
            $decodedValues['followed'],
            $decodedValues['username'],
            $decodedValues['reponame'],
            array_keys($decodedValues['branches'])
        );

        return $project;
    }

    public function normalize(): array
    {
        return [
            'vcs_url' => $this->vcsUrl,
            'followed' => $this->followed,
            'username' => $this->username,
            'reponame' => $this->reponame,
            'branches' => $this->branches,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->normalize());
    }
}
