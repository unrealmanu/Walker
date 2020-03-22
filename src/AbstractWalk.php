<?php

namespace unrealmanu\Walker;

use Generator;
use unrealmanu\Walker\DTO\WalkOptionsInterface;

/**
 * Class AbstractWalk
 * @package unrealmanu\Walker
 */
abstract class AbstractWalk implements WalkInterface
{

    /**
     * @var int
     */
    protected $depthLvl = 0;

    /**
     * @var WalkOptionsInterface
     */
    protected $options;

    /**
     * AbstractWalk constructor.
     * @param WalkOptionsInterface $options
     */
    public function __construct(WalkOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * @param WalkOptionsInterface $options
     * @return WalkOptionsInterface
     */
    public function setOptions(WalkOptionsInterface $options): WalkOptionsInterface
    {
        return $this->options = $options;
    }

    /**
     * @return WalkOptionsInterface
     */
    public function getOptions(): WalkOptionsInterface
    {
        return $this->options;
    }

    /**
     * @return bool
     */
    protected function getRecursiveProcessStatus(): bool
    {
        return $this->options->getRecursiveProcessStatus();
    }

    /**
     * @return array
     */
    protected function getValidInstance(): array
    {
        return $this->options->getFilterInstance();
    }

    /**
     * @return int
     */
    protected function getDepthLimit(): int
    {
        return $this->options->getRecursiveDepthLimit();
    }

    /**
     * @return int
     */
    public function getDephLevel(): int
    {
        return $this->depthLvl;
    }

    /**
     * @return int
     */
    protected function nextDepthLvl(): int
    {
        return $this->depthLvl = $this->getDephLevel() + 1;
    }

    /**
     * @param int $depth
     */
    protected function setDepthLvl(int $depth): void
    {
        $this->depthLvl = $depth;
    }

    /**
     * @param $item
     * @return bool
     */
    private function instanceFilter($item): bool
    {
        $result = false;
        $instances = $this->getValidInstance();
        if (count($instances) > 0) {
            foreach ($instances as $instance) {
                if ($item instanceof $instance) {
                    return true;
                }
            }
        } else {
            return true;
        }
        return $result;
    }

    /**
     * @param mixed $item
     * @return bool
     */
    public function itemFilter($item): bool
    {
        return true;
    }

    /**
     * @param mixed $parent
     */
    abstract function loadChildren($parent);

    /**
     * @param $parent
     * @return Generator
     */
    protected function recursive($parent): Generator
    {

        if ($this->getDepthLimit() == -1 || $this->getDephLevel() < $this->getDepthLimit()) {
            $results = $this->loadChildren($parent);
            if (is_object($results) || (is_array($results) && count($results) > 0)) {

                $this->nextDepthLvl();
                foreach ($results as $item) {

                    if ($this->instanceFilter($item) && $this->itemFilter($item)) {
                        yield $item;
                    }


                    if ($this->getRecursiveProcessStatus()) {
                        yield from $this->recursive($item);
                    }

                }
            }
        }
    }


    /**
     * @param $parent
     * @return array
     */
    public function walk($parent): array
    {
        $this->setDepthLvl(0);
        $results = [];

        foreach ($this->recursive($parent) as $item) {
            if ($item) {
                $results[] = $item;
            }
        }

        return $results;
    }

    /**
     * @param $parent
     * @return Generator
     */
    public function walkGen($parent): Generator
    {
        return $this->recursive($parent);
    }

}
