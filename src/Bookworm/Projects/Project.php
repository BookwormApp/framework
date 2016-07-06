<?php

namespace Bookworm\Projects;

use Bookworm\Users\User;
use Bookworm\Cases\ProjectCase;
use Bookworm\Projects\UrlGenerator;
use Bookworm\Support\Entities\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model {

    use SoftDeletes, UrlGenerator;

    protected $table = 'projects';
    protected $fillable = ['status','title','slug'];

    /* Relations */

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function cases()
    {
        return $this->hasMany(ProjectCase::class);
    }

    /* Helpers */

    public function getUrl()
    {
        return $this->slug;
    }

    public function editUrl($suffix = '')
    {
        return url(rtrim('settings/projects/'.$this->ref.'/'.$suffix, '/'));
    }

    public function is(Project $project = null)
    {
        if (is_null($project)) {
            return false;
        }

        return $this->id == $project->id;
    }

}
