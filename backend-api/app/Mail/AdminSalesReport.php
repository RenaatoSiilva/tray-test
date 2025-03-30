<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AdminSalesReport extends Mailable
{
    use Queueable, SerializesModels;

    public $csvPath;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($csvPath, string $date)
    {
        $this->csvPath    = $csvPath;
        $this->date     = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Relatório de Vendas Diário - {$this->date}")->view('emails.admin-sales-report')
            ->attach($this->csvPath, [
                'as' => "Relatorio_Vendas_{$this->date}.csv",
                'mime' => 'text/csv',
            ]);;
    }
}
