<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SpinWinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $phone;

    public $prizeName;

    public $prizeDescription;

    public $timestamp;

    public $pageUrl;

    public $pageTitle;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->phone = $data['phone'] ?? 'Не указан';
        $this->prizeName = $data['prize_name'] ?? 'Не указан';
        $this->prizeDescription = $data['prize_description'] ?? null;
        $this->timestamp = now()->format('d.m.Y H:i');
        $this->pageUrl = $data['page_url'] ?? 'Не указана';
        $this->pageTitle = $data['page_title'] ?? 'Не указан';
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Новый выигрыш в колесе')
            ->view('emails.spin-win');
    }
}
