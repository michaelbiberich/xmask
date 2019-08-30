<?php

declare(strict_types=1);

namespace MichaelBiberich\Xmask;

use \InvalidArgumentException;
use function \count;
use function \str_split;
use function \implode;

final class Xmask
{
    private $pattern;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $mask, array $substitutions)
    {
        $this->assertValidMask($mask);
        $this->assertValidSubstitutions($substitutions);

        $pattern = $this->toPattern($mask, $substitutions);

        $this->pattern = $pattern;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertValidMask(string $mask): void
    {
        if ($mask === '') {
            throw new InvalidArgumentException('$mask must not be empty string');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertValidSubstitutions(array $substitutions): void
    {
        if (count($substitutions) === 0) {
            throw new InvalidArgumentException('$substitutions must not be empty array');
        }
    }

    private function toPattern(string $mask, array $substitutions): string
    {
        $patternParts = [];
        $patternParts[] = '/^';

        foreach (str_split($mask) as $maskPart) {
            $patternParts[] = $this->substitute($maskPart, $substitutions);
        }

        $patternParts[] = '$/';

        return implode('', $patternParts);
    }

    private function substitute(string $maskPart, array $substitutions): string
    {
        return array_key_exists($maskPart, $substitutions)
            ? "([{$substitutions[$maskPart]}]{1})"
            : $maskPart;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }
}
