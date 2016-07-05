<?php

namespace Bookworm\Projects;

use Bookworm\Exceptions\StorageException;
use Origami\Support\Entities\DbRepository;
use Origami\Support\Entities\PaginateTrait;
use Origami\Support\Entities\ReferenceTrait;

class ProjectRepository extends DbRepository {

    use PaginateTrait, ReferenceTrait;

    /**
     * @var \Bookworm\Projects\Project
     */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function findBySlug($slug)
    {
        return $this->newQuery()->where('slug','=',$slug)->first();
    }

    public function allActive()
    {
        $query = $this->newQuery();

        $query->orderBy('updated_at','desc');

        return $query->get();
    }

    public function search(array $filters = [], $sort = null, $paginate = true)
    {
        $query = $this->buildSearchQuery($filters, $sort);

        return $paginate ? $this->buildPaginatedResults($query) : $query->get();
    }

    protected function buildSearchQuery(array $filters, $sort = null, $query = null)
    {
        $query = $query ?: $this->newQuery();

        $query->where(function($q) use($filters)
        {
            if ( $keywords = array_get($filters, 'q') ) {
                $q->search($keywords);
            }
        });

        $sort = $this->parseSortOrder($sort ?: 'created_at.desc');

        switch ( $sort['field'] ) {
            case 'title':
                $query->orderBy('title',$sort['direction']);
                break;
            case 'date':
            case 'created_at':
            default:
                $query->orderBy('created_at',$sort['direction']);
        }

        return $query;
    }

    public function create(array $fields, array $related = [])
    {
        $project = $this->project->newInstance($fields);
        $project->ref = $this->newProjectRef();

        if ( $createdBy = array_get('createdBy', $related) ) {
            $project->createdBy()->associate($createdBy);
        }

        if ( ! $project->save() ) {
            throw new StorageException;
        }

        return $project;
    }

    public function update(Project $project, array $fields)
    {
        $project->fill($fields);

        if ( ! $project->save() ) {
            throw new StorageException;
        }

        return $project;
    }

    public function delete(Project $project)
    {
        if ( ! $project->delete() ) {
            throw new StorageException;
        }

        return true;
    }

    protected function newProjectRef()
    {
        return $this->newUniqueRef($this->newQuery(), 4, 'ref', 'numeric');
    }

    protected function newQuery()
    {
        return $this->project->newQuery();
    }
}
