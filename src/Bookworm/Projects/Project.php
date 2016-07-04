<?php

namespace Bookworm\Projects;

use Bookworm\Cases\ProjectCase;
use Bookworm\Support\Entities\Model;
use Bookworm\Users\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model {

    use SoftDeletes;

    protected $table = 'projects';
    protected $fillable = ['status','title'];

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

    public function url($suffix = '')
    {
        return url(rtrim('settings/projects/'.$this->ref.'/'.$suffix, '/'));
    }

}
