<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
<<<<<<< HEAD
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function index(Request $request)
    {
=======
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * Display a listing of skills.
     */
    public function index(Request $request)
    {
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
        $skills = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'list', $request->all())
        );

<<<<<<< HEAD
        if (method_exists($skills, 'load')) {
            $skills->load('category');
        }

=======
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
        return SkillResource::collection($skills);
    }

    public function store(StoreSkillRequest $request)
    {
        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'create', $request->validated())
        );

        return new SkillResource($skill);
    }

<<<<<<< HEAD
    public function show($id)
    {
        $skill = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'get', ['id' => (int)$id])
        );

        if ($skill && method_exists($skill, 'load')) {
            $skill->load('category');
        }
=======
    /**
     * Display the specified skill.
     */
    public function show(int $id)
    {
        $skill = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'get', ['id' => $id])
        );

        return new SkillResource($skill);
    }

    /**
     * Update the specified skill.
     */
    public function update(UpdateSkillRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'update', $payload)
        );
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25

        return new SkillResource($skill);
    }

<<<<<<< HEAD
    public function update(UpdateSkillRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'update', $payload)
=======
    /**
     * Remove the specified skill.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Skill', 'delete', ['id' => $id])
>>>>>>> 2e1134428b69e648105d8dc41d4515424c01eb25
        );

        return new SkillResource($skill);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Skill', 'delete', ['id' => (int)$id])
        );

        return response()->noContent(); // 204 standard response
    }
}
