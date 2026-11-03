<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use InvalidArgumentException;
use Override;

final class EntityRegistry implements EntityRegistryInterface
{

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        return config('entities', []);
    }

    /**
     * @inheritdoc
     */
    public function get(string $entity): array
    {
        $configuration = config("entities.{$entity}");

        if ($configuration === null) {
            throw new InvalidArgumentException(
                "Entity [{$entity}] is not registered."
            );
        }

        return $configuration;
    }

    /**
     * @inheritdoc
     */
    public function has(string $entity): bool
    {
        return array_key_exists($entity, $this->all());
    }

    /**
     * @inheritdoc
     */
    public function actions(string $entity): array
    {
        return $this->get($entity)['actions'];
    }

    /**
     * @inheritdoc
     */
    public function fields(string $entity): array
    {
        return $this->get($entity)['fields'] ?? [];
    }

    /**
     * @inheritdoc
     */
    public function recordScopes(string $entity): array
    {
        return $this->get($entity)['record_scopes'];
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function sort(string $entity): array
    {
        if(!$this->has($entity)) {
            return [];
        }

        $fields = $this->fields($entity);

        return array_filter(
            $fields,
            fn (array $config): bool => array_key_exists('sort', $config)
        );
    }
}