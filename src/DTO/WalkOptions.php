<?php

namespace unrealmanu\Walker\DTO;

use stdClass;

class WalkOptions implements WalkOptionsInterface
{
    /**
     * @var bool $recursiveProcess
     */
    private $recursiveProcess = true;

    /**
     * @var int
     */
    private $recursiveDepthLimit = -1;

    /**
     * @var array
     */
    private $filterInstance = [];

    /**
     * @param bool $status
     * @return bool
     */
    public function setRecursiveProcessStatus(bool $status = true): bool
    {
        $this->recursiveProcess = $status;
        return $status;
    }

    /**
     * @return bool
     */
    public function getRecursiveProcessStatus(): bool
    {
        return $this->recursiveProcess;
    }

    /**
     * @return array
     */
    public function getFilterInstance(): array
    {
        return $this->filterInstance;
    }

    /**
     * @return int
     */
    public function getRecursiveDepthLimit(): int
    {
        return $this->recursiveDepthLimit;
    }

    /**
     * @param int $recursiveDepthLimit
     */
    public function setRecursiveDepthLimit(int $recursiveDepthLimit): void
    {
        $this->recursiveDepthLimit = $recursiveDepthLimit;
    }

    /**
     * @param array $class
     * @return array
     */
    public function setFilterInstance(array $class): array
    {
        $validItems = [];
        foreach ($class as $item){
            if($this->isValidItemForFilter($item)){
                $validItems[] = $item;
            }
        }
        $this->filterInstance = $validItems;
        return $validItems;
    }

    /**
     * @param $item
     * @return bool
     */
    public function isValidItemForFilter($item): bool
    {
        $accept = false;
        try {
            return $this->isClass($item);
        } catch (\Exception $e) {
        }
        return $accept;
    }

    /**
     * @param $class
     * @return bool
     */
    protected function isClass($class): bool
    {
        if (class_exists($class)) {
            return true;
        }
        return false;
    }
}
