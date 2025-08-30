<?php

namespace App\Observers;

use App\Models\UserVideoTask;

class TaskObserver
{
    /**
     * Handle the UserVideoTask "created" event.
     */
    public function created(UserVideoTask $userVideoTask): void
    {
        //
    }

    /**
     * Handle the UserVideoTask "updated" event.
     */
    public function updated(UserVideoTask $userVideoTask): void
    {
        //
    }

    /**
     * Handle the UserVideoTask "deleted" event.
     */
    public function deleted(UserVideoTask $userVideoTask): void
    {
        //
    }

    /**
     * Handle the UserVideoTask "restored" event.
     */
    public function restored(UserVideoTask $userVideoTask): void
    {
        //
    }

    /**
     * Handle the UserVideoTask "force deleted" event.
     */
    public function forceDeleted(UserVideoTask $userVideoTask): void
    {
        //
    }
}
