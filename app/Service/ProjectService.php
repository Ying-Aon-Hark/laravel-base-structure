<?php

namespace App\Service;

use App\Contracts\Service\ProjectServiceInterface;
use App\Contracts\Dao\ProjectDaoInterface;
use App\Service\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectService implements ProjectServiceInterface
{
    private $projectDao;
    private $fileService;

    public function __construct(ProjectDaoInterface $projectDao, FileService $fileService)
    {
        $this->projectDao = $projectDao;
        $this->fileService = $fileService;
    }

    public function getProjectCollection($query)
    {
        return $this->projectDao->getProjectCollection($query);
    }

    public function getProject($projectId)
    {
        return $this->projectDao->getProject($projectId);
    }

    public function createProject($request)
    {
        DB::beginTransaction();
        try {
            $projectRequest = $request->only(['title', 'description']);
            $project = $this->projectDao->createProject($projectRequest);
            if ($request->hasFile('file')) {
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                $this->fileService->uploadFile($request, 'file', 'MediaObject', 'project', $allowedMimeTypes, $project->id);
            }
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProject($projectId, $request)
    {
        DB::beginTransaction();
        try {
            $projectRequest = $request->only(['title', 'description']);
            $project = $this->projectDao->updateProject($projectId, $projectRequest);
            if ($request->hasFile('file')) {
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
                $this->fileService->uploadFile($request, 'file', 'MediaObject', 'project', $allowedMimeTypes, $project->id);
            }
            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProject($projectId)
    {
        return $this->projectDao->deleteProject($projectId);
    }
}
