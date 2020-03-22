<?php

namespace unrealmanu\Walker\DTO;

/**
 * Interface WalkOptionsInterface
 * @package unrealmanu\Walker\DTO
 */
interface WalkOptionsInterface
{
    /**
     * @return bool
     */
    public function getRecursiveProcessStatus(): bool;

    /**
     * @return array
     */
    public function getFilterInstance(): array;

    /**
     * @return int
     */
    public function getRecursiveDepthLimit(): int;

    /**
     * @param bool $status
     * @return bool
     */
    public function setRecursiveProcessStatus(bool $status = true): bool;

    /**
     * @param array $class
     * @return array
     */
    public function setFilterInstance(array $class): array;

    /**
     * @param int $recursiveDepthLimit
     */
    public function setRecursiveDepthLimit(int $recursiveDepthLimit): void;
}
