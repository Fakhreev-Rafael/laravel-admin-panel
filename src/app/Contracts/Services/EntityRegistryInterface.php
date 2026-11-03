<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use InvalidArgumentException;

interface EntityRegistryInterface
{
    /**
     * Return all entities.
     * 
     * @return array
     */
    public function all(): array;

    /**
     * Return entity by classname.
     * 
     * @param string $entity
     * 
     * @return array
     * 
     * @throws InvalidArgumentException
     */
    public function get(string $entity): array;

    /**
     * Check for having the entity.
     * 
     * @param string $entity
     * 
     * @return bool
     */
    public function has(string $entity): bool;

    /**
     * Return actions by entity.
     * 
     * @param string $entity
     * 
     * @return array
     */
    public function actions(string $entity): array;

    /**
     * Return fields by entity.
     * 
     * @param string $entity
     * 
     * @return array
     */
    public function fields(string $entity): array;

    /**
     * Return record scopes by entity.
     * 
     * @param string $entity
     * 
     * @return array
     */
    public function recordScopes(string $entity): array;

    /**
     * Return sort by entity
     * 
     * @param string $entity
     * 
     * @return array
     */
    public function sort(string $entity): array;
}