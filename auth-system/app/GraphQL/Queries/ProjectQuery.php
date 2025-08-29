<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class ProjectQuery
{
    /**
     * Fetch all projects with related status and technologies from MongoDB
     */
    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('projects');
        /** @var \MongoDB\Driver\CursorInterface $cursor */
        $cursor = $collection->find();

        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            return [
                'id' => isset($d->id) ? (int) $d->id : null,
                'title' => $d->title ?? null,
                'slug' => $d->slug ?? null,
                'description' => $d->description ?? null,
                'status' => $d->status ?? null, // should include 'id' and 'name'
                'start_date' => $d->start_date ?? null,
                'end_date' => $d->end_date ?? null,
                'is_featured' => $d->is_featured ?? false,
                'technologies' => $d->technologies ?? [], // array of technology objects {id, name}
                'created_at' => $d->created_at ?? null,
                'updated_at' => $d->updated_at ?? null,
            ];
        }, $docs);
    }

    /**
     * Fetch a single project by ID
     */
    public function find($root, array $args): ?array
    {
        $id = (int) ($args['id'] ?? 0);
        if (!$id) return null;

        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('projects');

        $doc = $collection->findOne(['id' => $id]);

        if (!$doc) return null;

        return [
            'id' => isset($doc->id) ? (int) $doc->id : null,
            'title' => $doc->title ?? null,
            'slug' => $doc->slug ?? null,
            'description' => $doc->description ?? null,
            'status' => $doc->status ?? null,
            'start_date' => $doc->start_date ?? null,
            'end_date' => $doc->end_date ?? null,
            'is_featured' => $doc->is_featured ?? false,
            'technologies' => array_map(function ($t) {
                return [
                    'id' => $t['id'] ?? null,
                    'name' => $t['name'] ?? null,
                    'slug' => $t['slug'] ?? null,
                    'icon' => $t['icon'] ?? null,
                    // 'meta' => isset($t['meta']) ? json_encode($t['meta']) : null,
                    'created_at' => $t['created_at'] ?? null,
                    'updated_at' => $t['updated_at'] ?? null,
                ];
            }, $doc->technologies ?? []),
            'created_at' => $doc->created_at ?? null,
            'updated_at' => $doc->updated_at ?? null,
        ];
    }
}
