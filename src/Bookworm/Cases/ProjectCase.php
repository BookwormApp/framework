<?php

namespace Bookworm\Cases;

use Bookworm\Projects\Project;
use Bookworm\Support\Entities\Model;
use Bookworm\Users\User;

class ProjectCase extends Model {

    protected $table = 'cases';
    protected $fillable = ['title','description','status','type','priority','due_at','completed_at'];
    protected $casts = ['completed' => 'boolean'];
    protected $dates = ['due_at', 'completed_at'];

    /* Relations */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'case_user');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /* Helpers */

    public function isCompleted()
    {
        return $this->completed;
    }

    public function hasStatus($status)
    {
        return $this->status == $status;
    }

    public function url($suffix = '')
    {
        return url(rtrim('cases/'.$this->ref.'/'.$suffix, '/'));
    }

}
