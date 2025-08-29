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
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function index(Request $request)
    {
        $skills = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'list', $request->all())
        );

        if (method_exists($skills, 'load')) {
            $skills->load('category');
        }

        return SkillResource::collection($skills);
    }

    public function store(StoreSkillRequest $request)
    {
        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'create', $request->validated())
        );

        return new SkillResource($skill);
    }

    public function show($id)
    {
        $skill = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'get', ['id' => (int)$id])
        );

        if ($skill && method_exists($skill, 'load')) {
            $skill->load('category');
        }

        return new SkillResource($skill);
    }

    public function update(UpdateSkillRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'update', $payload)
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
