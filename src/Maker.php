<?php

declare(strict_types=1);

namespace Danilocgsilva\PhpClassMaker;

class Maker
{
    private string $namespace;

    private bool $strictType = false;

    private string $className;

    /** @var MakerFunction[] */
    private array $makerFunctions = [];
    
    public function getString(): string
    {
        $fileContent = "<?php" . PHP_EOL;

        if ($this->strictType) {
            $fileContent .= PHP_EOL . "declare(strict_types=1);" . PHP_EOL;
        }

        if (isset($this->namespace)) {
            $fileContent .= PHP_EOL;
            $fileContent .= "namespace " . $this->namespace . ";";
            $fileContent .= PHP_EOL;
        }

        if (isset($this->className)) {
            $fileContent .= PHP_EOL;
            $fileContent .= "class " . $this->className . PHP_EOL;
            $fileContent .= "{" . PHP_EOL;
            foreach ($this->makerFunctions as $makerFunction) {
                $fileContent .= $this->addFourSpaces($makerFunction->getFunctionString());
            }
            $fileContent .= "}" . PHP_EOL;
        }

        return $fileContent;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function setStrictType(): self
    {
        $this->strictType = true;
        return $this;
    }

    public function setClassName(string $className): self
    {
        $this->className = $className;
        return $this;
    }

    public function addMakerFunction(MakerFunction $makerFunction): self
    {
        $this->makerFunctions[] = $makerFunction;
        return $this;
    }

    private function addFourSpaces(string $text): string
    {
        $lineArray = explode(PHP_EOL, $text);
        $eachLineWithMoreFourSpaces = array_map(function (string $line) {
            if ($line !== "") {
                return "    " . $line;
            }
            return "";
        }, $lineArray);
        
        return implode(PHP_EOL, $eachLineWithMoreFourSpaces);
    }
}
