<?php

namespace App\Service;

use App\Contracts\Service\ProjectServiceInterface;
use App\Contracts\Dao\MediaObjectDaoInterface;

class ProjectService implements ProjectServiceInterface
{
    private $mediaObjectDao;

    public function __construct(MediaObjectDaoInterface $mediaObjectDao)
    {
        $this->mediaObjectDao = $mediaObjectDao;
    }

    public function getProjectCollection($query)
    {
        return $this->mediaObjectDao->getProjectCollection($query);
    }

    public function getProject($mediaObjectId)
    {
        return $this->mediaObjectDao->getProject($mediaObjectId);
    }

    public function createProject($request)
    {
        return $this->mediaObjectDao->createProject($request);
    }

    public function updateProject($mediaObjectId, $request)
    {
        return $this->mediaObjectDao->updateProject($mediaObjectId, $request);
    }

    public function deleteProject($mediaObjectId)
    {
        return $this->mediaObjectDao->deleteProject($mediaObjectId);
    }

    public function getMediaObjectsByProjectId($projectId)
    {
        return $this->mediaObjectDao->getMediaObjectsByProjectId($projectId);
    }
}
