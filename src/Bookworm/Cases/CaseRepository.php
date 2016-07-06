<?php

namespace Bookworm\Cases;

use Bookworm\Projects\Project;
use Bookworm\Exceptions\StorageException;
use Bookworm\Support\Entities\DbRepository;
use Origami\Support\Entities\PaginateTrait;
use Origami\Support\Entities\ReferenceTrait;

class CaseRepository extends DbRepository {

    use PaginateTrait, ReferenceTrait;

    /**
     * @var \Bookworm\Cases\ProjectCase
     */
    private $case;

    public function __construct(ProjectCase $case)
    {
        $this->case = $case;
    }

    public function boardForProject(Project $project)
    {
        $query = $this->newQuery();

        $query->where('project_id','=',$project->id)
                ->orderBy('updated_at', 'desc');

        $results = $query->get();

        $cases = collect();

        foreach ( ['open', 'progress', 'closed'] as $status ) {
            $cases->put($status, $results->filter(function($case) use($status) {
                return $case->hasStatus($status);
            }));
        }

        return $cases;
    }

    public function search(array $filters = [], $sort = null, $paginate = true)
    {
        $query = $this->buildSearchQuery($filters, $sort);

        return $paginate ? $this->buildPaginatedResults($query) : $query->get();
    }

    public function searchForProject(Project $project, array $filters = [], $sort = null, $paginate = true)
    {
        $query = $this->buildSearchQuery($filters, $sort);

        $query->where('project_id','=',$project->id);

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
        $case = $this->case->newInstance($fields);
        $case->ref = $this->newCaseRef();
        $case->status = 'open';

        if ( $project = array_get($related, 'project') ) {
            $case->project()->associate($project);
        }

        if ( $createdBy = array_get($related, 'createdBy') ) {
            $case->createdBy()->associate($createdBy);
        }

        if ( $assignedTo = array_get($related, 'assignedTo') ) {
            $case->assignedTo()->associate($assignedTo);
        }

        if ( $completedBy = array_get($related, 'completedBy') ) {
            $case->completedBy()->associate($completedBy);
        }

        if ( ! $case->save() ) {
            throw new StorageException;
        }

        return $case;
    }

    public function update(ProjectCase $case, array $fields, array $related = [])
    {
        $case->fill($fields);

        if ( $project = array_get($related, 'project') ) {
            $case->project()->associate($project);
        }

        if ( ! $case->save() ) {
            throw new StorageException;
        }

        return $case;
    }

    public function delete(ProjectCase $case)
    {
        if ( ! $case->delete() ) {
            throw new StorageException;
        }

        return true;
    }

    public function newCaseRef()
    {
        return $this->newSequentialRef($this->newQuery(), '10', 2, 'ref');
    }

    protected function newQuery()
    {
        return $this->case->newQuery();
    }
}
