<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    public $phone;

    public $userEmail;

    public $userMessage;

    public $formType;

    public $timestamp;

    /**
     * Create a new message instance.
     */
    public function __construct($formData)
    {
        $this->name = $formData['name'] ?? 'Не указано';
        $this->phone = $formData['phone'] ?? 'Не указан';
        $this->userEmail = $formData['email'] ?? 'Не указан';
        $this->userMessage = $formData['message'] ?? 'Без сообщения';
        $this->formType = $formData['form_type'] ?? 'contact';
        $this->timestamp = now()->format('d.m.Y H:i');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Новая заявка с сайта йоги')
            ->view('emails.contact-form-final');
    }
}
