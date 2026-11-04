<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use App\Models\Entity;
use InvalidArgumentException;
use Override;

final class EntityRegistry implements EntityRegistryInterface
{

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        return Entity::query()
            ->with([
                'actions.scopes',
                'fields.actions',
                'fields.sort',
                'recordScopes',
            ])
            ->get()
            ->mapWithKeys(
                fn(Entity $entity): array => [
                    $entity->slug => $this->transform($entity),
                ]
            )
            ->all();
    }

    /**
     * @inheritdoc
     */
    public function get(string $entity): array
    {
        return $this->all()[$entity] ?? [];
    }

    /**
     * @inheritdoc
     */
    public function has(string $entity): bool
    {
        return Entity::query()
            ->where('slug', $entity)
            ->exists();
    }

    /**
     * @inheritdoc
     */
    public function actions(string $entity): array
    {
        return $this->get($entity)['actions'] ?? [];
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
        return $this->get($entity)['record_scopes'] ?? [];
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function sort(string $entity): array
    {
        return array_filter(
            $this->fields($entity),
            fn(array $config): bool =>
            array_key_exists('sort', $config)
        );
    }

    /**
     * Transform the values.
     * 
     * @param \App\Models\Entity $entity
     * 
     * @return array
     */
    private function transform(Entity $entity): array
    {
        $actions = [];

        foreach ($entity->actions as $action) {
            $slug = "{$entity->slug}.{$action->action}";

            $actions[$action->action] = [
                'name' => "permissions.{$slug}",
                'description' => "permissions.{$slug}_description",
                'scopes' => $action->scopes
                    ->pluck('scope')
                    ->all(),
            ];
        }

        $fields = [];

        foreach ($entity->fields as $field) {
            $config = [
                'actions' => $field->actions
                    ->pluck('action')
                    ->all(),
            ];

            if ($field->sort !== null) {
                $directions = [];

                if ($field->sort->allow_asc) {
                    $directions[] = 'asc';
                }

                if ($field->sort->allow_desc) {
                    $directions[] = 'desc';
                }

                $config['sort'] = [
                    'default' => $field->sort->is_default,
                    'default_direction' => $field->sort->default_direction,
                    'directions' => $directions,
                ];
            }

            $fields[$field->field] = $config;
        }

        return [
            'model' => $entity->model,
            'label' => $entity->label,
            'owner_field' => $entity->owner_field,
            'actions' => $actions,
            'fields' => $fields,
            'record_scopes' => $entity->recordScopes
                ->pluck('scope')
                ->all(),
        ];
    }
}
