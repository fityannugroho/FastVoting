<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    /**
     * @var string[] The list of error message.
     */
    private $messages = [
        'not_the_owner' => 'You are not the owner of this option',
        'not_the_event_owner' => 'You are not the owner of this event',
        'event_is_committed' => 'This event has been committed',
    ];

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Option $option)
    {
        if (empty($user)) {
            return false;
        }

        if ($user->id !== $option->event->user_id) {
            return $this->deny($this->messages['not_the_owner']);
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Event  $event The event that the option belongs to.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, \App\Models\Event $event)
    {
        if (empty($user)) {
            return false;
        }

        if ($user->id !== $event->user_id) {
            return $this->deny($this->messages['not_the_event_owner']);
        }

        if ($event->is_committed) {
            return $this->deny($this->messages['event_is_committed']);
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Option $option)
    {
        if (empty($user)) {
            return false;
        }

        if ($user->id !== $option->event->user_id) {
            return $this->deny($this->messages['not_the_owner']);
        }

        if ($option->event->is_committed) {
            return $this->deny($this->messages['event_is_committed']);
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Option $option)
    {
        if (empty($user)) {
            return false;
        }

        if ($user->id !== $option->event->user_id) {
            return $this->deny($this->messages['not_the_owner']);
        }

        if ($option->event->is_committed) {
            return $this->deny($this->messages['event_is_committed']);
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Option $option)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Option $option)
    {
        return false;
    }

    /**
     * Determine whether the user can access the option image.
     *
     * @param  \App\Models\User  $user The user who is trying to access the image.
     * @param  \App\Models\Option  $option The option that the image belongs to.
     * @param  \Illuminate\Support\Facades\Request  $request The request object. Used to get the voter's credentials (`voterId` and `token`).
     */
    public function getImage(?User $user, Option $option, $request = null)
    {
        // Allow access for the admins.
        if (optional($user)->is_admin) {
            return true;
        }

        // Allow access for the owner.
        if (optional($user)->id === $option->event->user_id) {
            return true;
        }

        // Allow access for the authenticated voters.
        if (optional($request)->has('voterId') && optional($request)->has('token')) {
            $voter = \App\Models\Voter::find(optional($request)->voterId);

            // Authenticate the voter.
            if (optional($voter)->token === optional($request)->token) {
                return true;
            }
        }

        return false;
    }
}
