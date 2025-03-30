<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CommissionReport extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $sales;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $userName, Collection $sales, string $date)
    {
        $this->userName    = $userName;
        $this->sales = $sales;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Comissões - {$this->date}")->view('emails.commission-report');
    }
}
