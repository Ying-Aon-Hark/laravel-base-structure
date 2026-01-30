<?php

namespace App\Contracts\Service;

interface ProjectServiceInterface
{
    public function getProjectCollection($query);
    public function getProject($projectId);
    public function createProject($request);
    public function updateProject($projectId, $request);
    public function deleteProject($projectId);
}
