<?php

declare(strict_types=1);

namespace MichaelBiberich\Xmask\Test\Unit;

use MichaelBiberich\Xmask\Xmask;
use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;

final class XmaskTest extends TestCase
{
    public function testConstructWithInvalidMaskFails(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Xmask('', []);
    }

    public function testConstructWithInvalidSubstitutionsFails(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Xmask('xxx456xxx', []);
    }

    public function testPatternContainsExactMaskWhenNoSubstitutionsApply(): void
    {
        $xmask = new Xmask('123456789', [
            'x' => '0-9',
        ]);

        $pattern = $xmask->pattern();

        $this->assertSame('/^123456789$/', $pattern);
    }

    public function testPatternContainsSubstitutedCharacterGroups(): void
    {
        $xmask = new Xmask('xxx456xxx', [
            'x' => '0-9',
        ]);

        $pattern = $xmask->pattern();

        $this->assertSame('/^([0-9]{1})([0-9]{1})([0-9]{1})456([0-9]{1})([0-9]{1})([0-9]{1})$/', $pattern);
    }
}

