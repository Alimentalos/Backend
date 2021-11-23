<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        return true;
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'comments', $user);
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->is_admin || $comment->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param User $user
     * @param Comment $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->is_admin || $comment->user_uuid === $user->uuid;
    }
}
