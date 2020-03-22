<?php


namespace unrealmanu\Walker;


use Generator;

interface WalkInterface
{

    /**
     * @param array $parent
     */
    public function loadChildren(array $parent);

    /**
     * @param $parent
     * @return array
     */
    public function walk($parent): array;

    /**
     * @param $parent
     * @return Generator
     */
    public function walkGen($parent): Generator;

}
