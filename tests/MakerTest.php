<?php

declare(strict_types=1);

namespace Tests;

use Danilocgsilva\PhpClassMaker\Maker;
use Danilocgsilva\PhpClassMaker\MakerFunction;
use Danilocgsilva\PhpClassMaker\Visibility;
use PHPUnit\Framework\TestCase;

class MakerTest extends TestCase
{
    private Maker $maker;
    
    public function setUp(): void
    {
        $this->maker = new Maker();
    }
    
    public function testGetString()
    {
        $expectedString = "<?php" . PHP_EOL;

        $this->assertSame(
            $expectedString,
            $this->maker->getString()
        );
    }

    public function testNamespaceGetString()
    {
        $expectedString = <<<EOL
<?php

namespace AuthorDefinition\PackageDefinition;

EOL;

        $this->maker->setNamespace("AuthorDefinition\PackageDefinition");

        $this->assertSame(
            $expectedString,
            $this->maker->getString()
        );
    }

    public function testSetStrictType()
    {
        $expectedContent = <<<EOF
<?php

declare(strict_types=1);

EOF;

        $this->maker->setStrictType();

        $this->assertSame(
            $expectedContent,
            $this->maker->getString()
        );
    }

    public function testSettingClassName()
    {
        $this->maker->setClassName("MyClassName");

        $expectedContent = <<<EOF
<?php

class MyClassName
{
}

EOF;
        $this->assertSame(
            $expectedContent,
            $this->maker->getString()
        );
    }

    public function testAllDefaultGoodPracticesClassConventions()
    {
        $this->maker->setStrictType();
        $this->maker->setNamespace("SomeAuthorHere\Definition");
        $this->maker->setClassName("DoYourStuff");

        $expextedString = <<<EOF
<?php

declare(strict_types=1);

namespace SomeAuthorHere\Definition;

class DoYourStuff
{
}

EOF;
        $this->assertSame(
            $expextedString,
            $this->maker->getString()
        );
    }

    public function testAddingFunction()
    {
        $this->maker->setStrictType();
        $this->maker->setNamespace("HenrySobel\BookToInform");
        $this->maker->setClassName("FirstAct");

        $makerFunction = new MakerFunction();
        $makerFunction->setVisibility(Visibility::public);
        $makerFunction->setName("helloPeople");
        $makerFunction->setContent("return \"This is your first stuff.\";");

        $this->maker->addMakerFunction($makerFunction);

        $expextedString = <<<EOF
<?php

declare(strict_types=1);

namespace HenrySobel\BookToInform;

class FirstAct
{
    public function helloPeople()
    {
        return "This is your first stuff.";
    }
}

EOF;
        $this->assertSame(
            $expextedString,
            $this->maker->getString()
        );
    }
}
