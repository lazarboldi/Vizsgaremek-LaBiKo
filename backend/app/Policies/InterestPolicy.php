<?php

namespace App\Policies;

use App\Models\Interest;
use App\Models\User;

class InterestPolicy
{
    /**
     * Determine if the user can update the interest.
     * Only the sender (user who created the interest) can update it.
     */
    public function update(User $user, Interest $interest): bool
    {
        return $user->id === $interest->sender_id;
    }

    /**
     * Determine if the user can delete the interest.
     * Both the sender and receiver can delete it.
     */
    public function delete(User $user, Interest $interest): bool
    {
        return $user->id === $interest->sender_id || $user->id === $interest->receiver_id;
    }
}
