<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;
use MongoDB\BSON\ObjectId;

class SkillQuery
{
    protected MongoClient $mongo;
    protected $collection;

    public function __construct()
    {
        // Initialize MongoDB connection
        $this->mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $this->collection = $this->mongo
            ->selectDatabase('read_model')
            ->selectCollection('skills');
    }

    /**
     * Map a MongoDB document to a Skill array (like an Eloquent model)
     */
    protected function mapDoc($doc): array
    {
        $category = isset($doc->category) ? (array)$doc->category : [];

        return [
            '_id' => isset($doc->_id) ? (string)$doc->_id : null,
            'id' => $doc->id ?? null,
            'name' => $doc->name ?? null,
            'level' => isset($doc->level) ? (int)$doc->level : null,
            'icon' => $doc->icon ?? null,
            'category' => [
                'id' => $category['id'] ?? null,
                'name' => $category['name'] ?? 'Uncategorized',
                'description' => $category['description'] ?? null,
            ],
            // Keep raw MongoDB fields; frontend can parse if needed
            'created_at' => $doc->created_at ?? null,
            'updated_at' => $doc->updated_at ?? null,
        ];
    }

    /**
     * Fetch all skills
     */
    public function all(): array
    {
        $cursor = $this->collection->find();
        $docs = iterator_to_array($cursor, false);

        return array_map(fn($doc) => $this->mapDoc($doc), $docs);
    }

    /**
     * Fetch a single skill by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        // Try numeric ID first
        $doc = $this->collection->findOne(['id' => (int)$id]);

        // If not found, try Mongo ObjectId
        if (!$doc) {
            try {
                $doc = $this->collection->findOne(['_id' => new ObjectId($id)]);
            } catch (\Exception $e) {
                $doc = null;
            }
        }

        if (!$doc) return null;

        return $this->mapDoc($doc);
    }
}
