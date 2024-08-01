<?php

namespace App\Jobs;

use App\Models\MailList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchJobVacancyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = MailList::all();

        $data = [
            'message' => __('models.new_job_added'),
            'name' => $this->data->title,
            'link' => route('site.news.show', $this->data->id)
        ];

        foreach ($users as $key => $user) {
            Mail::to($user->email)->send(new SubscripeMail($data));
        }
    }
}
