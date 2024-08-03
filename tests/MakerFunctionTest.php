<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\PhpClassMaker\MakerFunction;
use Exception;
use Danilocgsilva\PhpClassMaker\Visibility;

class MakerFunctionTest extends TestCase
{
    private MakerFunction $makerFunction;

    public function setUp(): void
    {
        $this->makerFunction = new MakerFunction();
    }

    public function testMissEverything()
    {
        $this->expectException(Exception::class);
        $this->makerFunction->getFunctionString();
    }

    public function testGetContentString()
    {
        $this->makerFunction->setName("myFunctionName");
        $this->makerFunction->setVisibility(Visibility::public );

        $expectedContentString = <<<EOF
public function myFunctionName()
{
}

EOF;

        $this->assertSame(
            $expectedContentString,
            $this->makerFunction->getFunctionString()
        );
    }

    public function testGetWithContent()
    {
        $this->makerFunction->setName("myFunctionName");
        $this->makerFunction->setVisibility(Visibility::public );
        $this->makerFunction->setContent("return \"Hello world!\";");
        $expectedContentString = <<<EOF
public function myFunctionName()
{
    return "Hello world!";
}

EOF;

        $this->assertSame(
            $expectedContentString,
            $this->makerFunction->getFunctionString()
        );
    }
}
