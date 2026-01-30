<?php

namespace App\Dao;

use App\Models\MediaObject;
use App\Contracts\Dao\MediaObjectDaoInterface;

class MediaObjectDao implements MediaObjectDaoInterface
{

    /**
     * Show MediaObject detail
     * @method showMediaObjectDetail
     * @param  int$mediaObjectId
     * @return MediaObject
     */
    public function getMediaObject($mediaObjectId)
    {
        return MediaObject::where('id', $mediaObjectId)->first();
    }

    /**
     * create MediaObject function
     * @method create
     * @param  Object $request
     * @return void
     */
    public function createMediaObject($request)
    {
        return MediaObject::create($request);
    }

    /**
     * update MediaObject by id
     * @method updateMediaObject
     * @param  int$mediaObjectId [description]
     * @param  Object $request [description]
     * @return void
     */
    public function updateMediaObject($mediaObject, $request)
    {
        return MediaObject::where('id', $request)->update($request);
    }


    /**
     * delete MediaObject by id
     * @method deleteMediaObject
     * @param  int$mediaObjectId [description]
     * @return void
     */
    public function deleteMediaObject($mediaObjectId)
    {
        MediaObject::where('id', $mediaObjectId)->delete();
    }

    /**
     * Get MediaObjects by Project ID
     * @method getMediaObjectsByProjectId
     * @param  int $projectId
     * @return Collection
     */
    public function getMediaObjectsByProjectId($projectId)
    {
        return MediaObject::where('project_id', $projectId)->get();
    }
}
