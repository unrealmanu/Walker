<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use unrealmanu\Walker\Walk;
use unrealmanu\Walker\DTO\WalkOptions;
use unrealmanu\Walker\DTO\WalkOptionsInterface;

final class ExampleObject
{
    public $text = "myText";

    public function getChildren()
    {
        return ["try 2nd level"];
    }
}


final class ExampleData
{
    private $object;

    public function __construct(ExampleObject $object)
    {
        $this->object = $object;
    }

    public function getChildren()
    {
        return ["XXX", $this->object];
    }
}

final class WalkTest extends TestCase
{
    public function testOptions()
    {
        $options = new WalkOptions();
        $walker = new Walk($options);
        $this->assertInstanceOf(Walk::class, $walker);
        $this->assertInstanceOf(WalkOptionsInterface::class, $options);
        $this->assertInstanceOf(WalkOptionsInterface::class, $walker->getOptions());
    }

    public function testRecursiveWalk()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(true);
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertIsArray($result);
        $this->assertIsString($result[0]);
        $this->assertInstanceOf(ExampleObject::class, $result[1]);
        $this->assertIsString($result[2]);
    }

    public function testRecursiveWalkOnlyFirstLevel()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(false);
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertIsArray($result);
        $this->assertIsString($result[0]);
        $this->assertInstanceOf(ExampleObject::class, $result[1]);
    }

    public function testRecursiveOnlyFirstLevelCheckIsReallyFirstLevelOfDepth()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(false);
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertTrue(($walker->getDephLevel() == 1));
    }

    public function testRecursiveGetDepth()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertIsInt($walker->getDephLevel());
    }

    public function testRecursiveWalkDepthLimit()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(true);
        $options->setRecursiveDepthLimit(1);
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertIsInt($walker->getDephLevel());
        $this->assertTrue(($walker->getDephLevel() == 1));
    }

    public function testRecursiveWalkGen()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(true);
        $walker = new Walk($options);
        $result = $walker->walkGen($parent);
        $this->assertInstanceOf(Generator::class, $result);
    }

    public function testRecursiveFilter()
    {
        $object = new ExampleObject();
        $parent = new ExampleData($object);
        $options = new WalkOptions();
        $options->setRecursiveProcessStatus(true);
        $options->setRecursiveDepthLimit(1);
        $options->setFilterInstance([ExampleObject::class]);
        $walker = new Walk($options);
        $result = $walker->walk($parent);
        $this->assertInstanceOf(ExampleObject::class, $result[0]);
    }
}
