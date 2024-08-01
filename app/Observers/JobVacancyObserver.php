<?php

namespace App\Observers;

use App\Jobs\DispatchJobVacancyJob;
use App\Models\JobVacancy;

class JobVacancyObserver
{
    /**
     * Handle the JobVacancy "created" event.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return void
     */
    public function created(JobVacancy $jobVacancy)
    {
        $delay = now()->addMinutes(10);

        Queue::later($delay, new DispatchJobVacancyJob($jobVacancy));
    }

    /**
     * Handle the JobVacancy "updated" event.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return void
     */
    public function updated(JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Handle the JobVacancy "deleted" event.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return void
     */
    public function deleted(JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Handle the JobVacancy "restored" event.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return void
     */
    public function restored(JobVacancy $jobVacancy)
    {
        //
    }

    /**
     * Handle the JobVacancy "force deleted" event.
     *
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return void
     */
    public function forceDeleted(JobVacancy $jobVacancy)
    {
        //
    }
}
