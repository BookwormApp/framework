<?php

namespace Bookworm\Users;

use Bookworm\Exceptions\StorageException;
use Bookworm\Support\Entities\DbRepository;
use Origami\Support\Entities\PaginateTrait;
use Origami\Support\Entities\ReferenceTrait;

class UserRepository extends DbRepository
{
    use PaginateTrait, ReferenceTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
            case 'name':
                $query->orderBy('name',$sort['direction']);
                break;
            case 'date':
            case 'created_at':
            default:
                $query->orderBy('created_at',$sort['direction']);
        }

        return $query;
    }

    public function create(array $fields)
    {
        $user = $this->user->newInstance($fields);
        $user->ref = $this->newUserRef();

        if (!$user->save()) {
            throw new StorageException;
        }

        return $user;
    }

    public function update(User $user, array $fields)
    {
        $user->fill($fields);

        if ( ! $user->save() ) {
            throw new StorageException;
        }

        return $user;
    }

    public function delete(User $user)
    {
        if ( ! $user->delete() ) {
            throw new StorageException;
        }

        return true;
    }

    protected function newUserRef()
    {
        return $this->newUniqueRef($this->newQuery(), 3, 'ref', 'numeric');
    }

    protected function newQuery()
    {
        return $this->user->newQuery();
    }
}
