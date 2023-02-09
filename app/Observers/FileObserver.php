<?php

namespace App\Observers;

use App\Models\File;

class FileObserver
{
    /**
     * Handle the File "created" event.
     *
     * @param File $file
     * @return void
     */
    public function created(File $file): void
    {

       $file->index(app('elasticsearch'), $file->index);

    }

    /**
     * Handle the File "updated" event.
     *
     * @param File $file
     * @return void
     */
    public function updated(File $file): void
    {
        //
    }

    /**
     * Handle the File "deleted" event.
     *
     * @param File $file
     * @return void
     */
    public function deleted(File $file): void
    {
        $file->delete_index(app('elasticsearch'));
    }

    /**
     * Handle the File "restored" event.
     *
     * @param File $file
     * @return void
     */
    public function restored(File $file): void
    {
        //
    }

    /**
     * Handle the File "force deleted" event.
     *
     * @param File $file
     * @return void
     */
    public function forceDeleted(File $file): void
    {
        //
    }
}
