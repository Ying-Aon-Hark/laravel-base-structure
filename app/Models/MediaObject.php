<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaObject extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'file_type', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
