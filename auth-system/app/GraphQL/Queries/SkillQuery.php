<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class SkillQuery
{
    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('skills');

        $cursor = $collection->find();
        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            return [
                '_id' => isset($d->_id) ? (string) $d->_id : null,  // ObjectId as string
                'id' => isset($d->id) ? (int) $d->id : null,
                'name' => $d->name ?? null,
                'level' => $d->level ?? null,
                'icon' => $d->icon ?? null,

                // 👇 FIX: return nested category as object for GraphQL
                'category' => isset($d->category) ? [
                    'id' => $d->category['id'] ?? null,
                    'name' => $d->category['name'] ?? null,
                    'description' => $d->category['description'] ?? null,
                ] : null,

                'created_at' => isset($d->created_at) ? $d->created_at : null,
                'updated_at' => isset($d->updated_at) ? $d->updated_at : null,
            ];
        }, $docs);
    }

    public function find($root, array $args): ?array
    {
        $id = (int) ($args['id'] ?? 0);
        if (!$id) return null;

        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('skills');

        $doc = $collection->findOne(['id' => $id]);
        if (!$doc) return null;

        return [
            '_id' => isset($doc->_id) ? (string) $doc->_id : null,
            'id' => isset($doc->id) ? (int) $doc->id : null,
            'name' => $doc->name ?? null,
            'level' => $doc->level ?? null,
            'icon' => $doc->icon ?? null,
            'category' => isset($doc->category) ? [
                'id' => $doc->category['id'] ?? null,
                'name' => $doc->category['name'] ?? null,
                'description' => $doc->category['description'] ?? null,
            ] : null,
            'created_at' => isset($doc->created_at) ? $doc->created_at : null,
            'updated_at' => isset($doc->updated_at) ? $doc->updated_at : null,
        ];
    }
}
