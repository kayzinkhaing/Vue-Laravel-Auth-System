<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class ProjectQuery
{
    protected MongoClient $mongo;
    protected $collection;

    public function __construct()
    {
        $this->mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $this->collection = $this->mongo
            ->selectDatabase('read_model')
            ->selectCollection('projects');
    }

    protected function mapTechnology(array $tech): array
    {
        return [
            'id' => isset($tech['id']) ? (string)$tech['id'] : null,
            'name' => $tech['name'] ?? null,
            'slug' => $tech['slug'] ?? null,
            'icon' => $tech['icon'] ?? null,
            'created_at' => $tech['created_at'] ?? null,
            'updated_at' => $tech['updated_at'] ?? null,
        ];
    }
    protected function mapStatus($status): ?array
    {
        if (!$status) {
            return null;
        }

        return [
            'id' => isset($status['id']) ? (string)$status['id'] : null,
            'name' => $status['name'] ?? null,
        ];
    }


    public function all(): array
    {
<<<<<<< HEAD
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('projects');
        /** @var \MongoDB\Driver\CursorInterface $cursor */
        $cursor = $collection->find();

=======
        $cursor = $this->collection->find();
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            $doc = json_decode(json_encode($d), true);
            return [
                'id' => isset($d->id) ? (string)$d->id : (string)($d->_id ?? ''),
                'title' => $d->title ?? null,
                'slug' => $d->slug ?? null,
                'description' => $d->description ?? null,
                'status' => $this->mapStatus((array)($d->status ?? null)),
                'start_date' => $d->start_date ?? null,  // string already
                'end_date' => $d->end_date ?? null,      // string already
                'is_featured' => $d->is_featured ?? false,
                'technologies' => array_map([$this, 'mapTechnology'], $doc['technologies'] ?? []),
                'created_at' => $d->created_at ?? null,  // string
                'updated_at' => $d->updated_at ?? null,  // string
            ];
        }, $docs);
    }

    public function find($root, array $args): ?array
    {
        $id = (string)($args['id'] ?? '');
        if (!$id) return null;

        $doc = $this->collection->findOne(['id' => (int)$id]);
        if (!$doc) return null;

        return [
            'id' => isset($doc->id) ? (string)$doc->id : (string)($doc->_id ?? ''),
            'title' => $doc->title ?? null,
            'slug' => $doc->slug ?? null,
            'description' => $doc->description ?? null,
            'status' => $doc->status ?? null,
            'start_date' => $doc->start_date ?? null,
            'end_date' => $doc->end_date ?? null,
            'is_featured' => $doc->is_featured ?? false,
            'technologies' => array_map([$this, 'mapTechnology'], $doc->technologies ?? []),
            'created_at' => $doc->created_at ?? null,
            'updated_at' => $doc->updated_at ?? null,
        ];
    }
}
