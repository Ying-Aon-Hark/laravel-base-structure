<?php

namespace App\Contracts\Service;

interface MediaObjectServiceInterface
{
    public function getMediaObject($mediaObjectId);
    public function createMediaObject($request);
    public function updateMediaObject($mediaObjectId, $request);
    public function deleteMediaObject($mediaObjectId);
    public function getMediaObjectsByProjectId($projectId);
}
