<?php

namespace App\Contracts\Dao;

interface MediaObjectDaoInterface
{
    public function getMediaObject($mediaObjectId);
    public function createMediaObject($request);
    public function updateMediaObject($mediaObjectId, $request);
    public function deleteMediaObject($mediaObjectId);
    public function getMediaObjectsByProjectId($projectId);
}
