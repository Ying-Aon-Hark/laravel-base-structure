<?php

namespace App\Dao;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Contracts\Dao\ProjectDaoInterface;
use App\Filters\OrSearchFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ProjectDao implements ProjectDaoInterface
{
    /**
     * show all projects
     * @method getProjectCollection
     * @return void
     */
    public function getProjectCollection($query)
    {
        $itemsPerPage = $query['itemsPerPage'] ?? config('constants.PAGINATION');
        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters([
                AllowedFilter::custom('OrSearch', new OrSearchFilter([
                    'title',
                    'description'
                ])),
            ])
            ->paginate($itemsPerPage);

        return ProjectResource::collection($projects);
    }

    /**
     * Show Project profile
     * @method showProjectDetail
     * @param  int $projectId
     * @return Project
     */
    public function getProject($projectId)
    {
        $project = Project::where('id', $projectId)->first();
        return new ProjectResource($project);
    }

    /**
     * create Project function
     * @method create
     * @param  Object $request
     * @return void
     */
    public function createProject($request)
    {
        $project = Project::create($request);
        return new ProjectResource($project);
    }

    /**
     * update Project by id
     * @method updateProject
     * @param  int $projectId [description]
     * @param  Object $request [description]
     * @return ProjectResource
     */
    public function updateProject($projectId, $request)
    {
        Project::where('id', $projectId)
            ->update($request);
        $project = $this->getProject($projectId);
        return new ProjectResource($project);
    }


    /**
     * delete Project by id
     * @method deleteProject
     * @param  int $projectId [description]
     * @return void
     */
    public function deleteProject($projectId)
    {
        Project::where('id', $projectId)->delete();
    }
}
