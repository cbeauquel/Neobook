<?php

namespace App\Tests\Enum;

use App\Enum\BasketStatus;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

final class BasketStatusTest extends TestCase
{
    public function testTransCallsTranslatorWithEnumName(): void
    {
        /** @var TranslatorInterface&\PHPUnit\Framework\MockObject\MockObject $translator */
        $translator = $this->createMock(TranslatorInterface::class);

        $translator
            ->expects($this->once())
            ->method('trans')
            ->with('IN_PROGRESS', [], null, null)
            ->willReturn('En cours');

        $result = BasketStatus::IN_PROGRESS->trans($translator);

        $this->assertSame('En cours', $result);
    }

    public function testEachEnumValueReturnsTranslatedName(): void
    {
        /** @var TranslatorInterface&\PHPUnit\Framework\MockObject\MockObject $translator */
        $translator = $this->createStub(TranslatorInterface::class);
        $translator->method('trans')->willReturnCallback(fn (string $id) => "translated_$id");

        foreach (BasketStatus::cases() as $status) {
            $translated = $status->trans($translator);
            $this->assertSame("translated_" . $status->name, $translated);
        }
    }
}
