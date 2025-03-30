<?php

namespace App\Jobs;

use App\Mail\ChangePassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class RecoveryPasswordEmail implements ShouldQueue
{
    use Queueable;

    public $email;
    public $password;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $password)
    {
        $this->email    = $email;
        $this->password = $password;
        $this->onQueue(config('queue.recovery_password'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ChangePassword($this->email, $this->password));
    }
}
