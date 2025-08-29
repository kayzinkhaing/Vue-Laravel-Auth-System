<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Page;
use MongoDB\Client;

class SyncPageToReadModel implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected int $id;
    protected string $action;

    public function __construct(int $id, string $action = 'update')
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function handle()
    {
        $page = Page::find($this->id);
        if (!$page) return;

        $client = new Client('mongodb://mongo:27017'); // adjust if needed
        $collection = $client->read_model->pages; // use "pages" collection

        $document = [
            '_id'       => $page->id,
            'id'        => $page->id,                // keep your SQL integer id
            'title'     => $page->title,
            'slug'      => $page->slug,
            'content'   => $page->content,
            'is_active' => $page->is_active,
            'created_at'=> $page->created_at,
            'updated_at'=> $page->updated_at,
        ];

        if ($this->action === 'update') {
            $collection->updateOne(
                ['_id' => $page->id],
                ['$set' => $document],
                ['upsert' => true]
            );
        } elseif ($this->action === 'delete') {
            $collection->deleteOne(['_id' => $page->id]);
        }
    }
}
