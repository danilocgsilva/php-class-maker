<?php

declare(strict_types=1);

namespace Danilocgsilva\PhpClassMaker;

use Exception;

class MakerFunction
{
    private string $content = "";

    private string $name;

    private Visibility $visibility;
    
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getFunctionString(): string
    {
        if (count($this->getMissingData()) > 0) {
            throw new Exception("There are missing data.");
        }
        
        $functionString = $this->getVisibilityString();
        $functionString .= " function " . $this->name . "()" . PHP_EOL;
        $functionString .= "{" . PHP_EOL;
        if ($this->content !== "") {
            $functionString .= $this->addFourSpacesLeftPad($this->content) . PHP_EOL;
        }
        $functionString .= "}" . PHP_EOL;

        return $functionString;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setVisibility(Visibility $visibility): self
    {
        $this->visibility = $visibility;
        return $this;
    }

    private function getVisibilityString(): string
    {
        switch ($this->visibility) {
            case Visibility::public:
                return "public";
            case Visibility::protected:
                return "protected";
            case Visibility::private:
                return "private";
            default:
                return "";
        }
    }

    private function getMissingData(): array
    {
        $missingData = [];
        if (!isset($this->name)) {
            $missingData[] = "name";
        }
        return $missingData;
    }

    private function addFourSpacesLeftPad(string $text): string
    {
        $contentLines = explode(PHP_EOL, $text);
        $contentLinesPadded = array_map(fn ($textLine) => "    " . $textLine, $contentLines);
        return implode(PHP_EOL, $contentLinesPadded);
    }
}
