<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Service\ProjectServiceInterface;

class ProjectController extends Controller
{
    private $projectService;

    /**
     * constructor
     * @method __construct
     * @param  ProjectServiceInterface $projectService
     */
    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query();
        $project = $this->projectService->getProjectCollection($query);
        return response()->json($project, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = $this->projectService->createProject($request);
        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = $this->projectService->getProject($id);
        return response()->json($project, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = $this->projectService->updateProject($id, $request);
        return response()->json($project, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Successfully Deleted'], 200);
    }
}
