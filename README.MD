# ABSTRACT WALKER
##### Manuel Trebbi <unrealmanumaster@gmail.com>

## Walk on the deepest level of object or array with filter by instance and control of deep level

### CMD LIST
#### Launch TEST:
```
composer test tests
```
#### Fix LINT
```
composer fix tests
composer fix src
```
#### Install GIT-HOOK
```
./scripts/install-hook.bash
```

## USAGE
##### Extends unrealmanu\Walker\AbstractWalker
##### example: 

- ./tests/Walk.php

### Necessary Method
```php

    abstract function loadChildren(array $parent): array;

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
```
#### METHOD

Define action to get object/array childrens and return this
```php
LoadChidren($parent)
```


Return array of walked elements
```php
walk($parent) [low performance - easy to use and check]
```

Return the "raw" generator used for walking in the deepest of elements... 
```php
walkGen($parent) [best perfomance]
```

Make your custom logic filter`for item of recursive processes in extension of asbtract class
```php
public function itemFilter($item): bool
``

#### OPTIONS
##### unrealmanu\Walker\DTO\WalkOptions (predefined)
##### unrealmanu\Walker\DTO\WalkOptionsInterface (for future implementation)

true = recursive, false = stop in first depth level
```php
    public function setRecursiveProcessStatus(bool $status = true): bool;
```
Set Class instance for filter the children in walking process
```php
    public function setFilterInstance(array $class): array;
```
Set the limit of deepest recursion level
```php
    public function setRecursiveDepthLimit(int $recursiveDepthLimit): void;
```




