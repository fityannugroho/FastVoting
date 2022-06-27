<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voter;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoterPolicy
{
    use HandlesAuthorization;

    /**
     * @var string[] The list of error message.
     */
    private $messages = [
        'not_the_owner' => 'You are not the owner of this voter',
        'event_is_committed' => 'This event has been committed'
    ];

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return isset($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Voter $voter)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return isset($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Voter $voter)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Voter $voter)
    {
        if (empty($user)) {
            return false;
        }

        if ($user->id !== $voter->event->user_id) {
            return $this->deny($this->messages['not_the_owner']);
        }

        if ($voter->event->is_committed) {
            return $this->deny($this->messages['event_is_committed']);
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Voter $voter)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Voter $voter)
    {
        return false;
    }
}
