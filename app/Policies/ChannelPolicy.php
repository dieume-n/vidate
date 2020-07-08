<?php

namespace App\Policies;

use App\User;
use App\Channel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Channel  $channel
     * @return mixed
     */
    public function view(User $user, Channel $channel)
    {
        return $user->id === $channel->user_id;
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Channel  $channel
     * @return mixed
     */
    public function update(User $user, Channel $channel)
    {
        return $user->id === $channel->user_id;
    }

    /**
     * Determine whether the user can subscribe the model.
     *
     * @param  \App\User  $user
     * @param  \App\Channel  $channel
     * @return mixed
     */
    public function subscribe(User $user, Channel $channel)
    {
        if ($user->isSubscribedTo($channel)) {
            return false;
        }

        return !$user->ownsChannel($channel);
    }

    /**
     * Determine whether the user can unsubscribe the model.
     *
     * @param  \App\User  $user
     * @param  \App\Channel  $channel
     * @return mixed
     */
    public function unsubscribe(User $user, Channel $channel)
    {
        return $user->isSubscribedTo($channel);
    }
}
