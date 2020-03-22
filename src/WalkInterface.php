<?php


namespace unrealmanu\Walker;


use Generator;

interface WalkInterface
{

    // CUSTOM ITEM FILTER LOGIC
    /**
     * @param mixed $item
     * @return bool
     */
    public function itemFilter($item): bool;

    // CUSTOM ITEM GET CHILDREN LOGIC
    /**
     * @param array $parent
     */
    public function loadChildren(array $parent);

    // WALK THE OBJECT/ARRAY AND RETURN ARRAY
    /**
     * @param mixed $parent
     * @return array
     */
    public function walk($parent): array;

    // WALK THE OBJECT/ARRAY AND RETURN GENERATOR [Better performance]
    /**
     * @param mixed $parent
     * @return Generator
     */
    public function walkGen($parent): Generator;

}
