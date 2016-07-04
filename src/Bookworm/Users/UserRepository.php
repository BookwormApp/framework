<?php

namespace Bookworm\Users;

use Bookworm\Exceptions\StorageException;
use Bookworm\Support\Entities\DbRepository;
use Origami\Support\Entities\ReferenceTrait;

class UserRepository extends DbRepository
{
    use ReferenceTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $fields)
    {
        $user = $this->user->newInstance($fields);
        $user->ref = $this->newUserRef();

        if (!$user->save()) {
            throw new StorageException();
        }

        return $user;
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
