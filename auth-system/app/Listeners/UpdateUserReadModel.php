<?php
namespace App\Listeners;

use App\Events\UserCreatedEvent;
use MongoDB\Client;

class UpdateUserReadModel
{
    // public function handle(UserCreatedEvent $event)
    // {
    //     $user = $event->user;

<<<<<<< HEAD
        $mongo = new Client("mongodb://mongo:27017");
        $collection = $mongo->selectDatabase('read_model')->users;

        $collection->updateOne(
            ['_id' => $user->id],
            [
                '$set' => [
                    'name'        => $user->name,
                    'email'       => $user->email,
                    'township_id' => $user->township_id,
                    'ward_id'     => $user->ward_id,
                    'created_at'  => $user->created_at,
                    'updated_at'  => $user->updated_at,
                ]
            ],
            ['upsert' => true]
        );
    }
=======
    //     $mongo = new Client("mongodb://mongo:27017");
    //     $collection = $mongo->selectDatabase('read_model')->users;
    //     $collection->drop();

    //     $collection->updateOne([
    //         '_id' => $user->id,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'township_id' => $user->township_id,
    //         'ward_id' => $user->ward_id,
    //         'created_at' => $user->created_at,
    //         'updated_at' => $user->updated_at,
    //     ]);
    // }
>>>>>>> 74dfbfcf7172135647e718dda03d2fe61c282731
}
