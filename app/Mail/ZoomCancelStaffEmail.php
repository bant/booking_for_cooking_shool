<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomCancelStaffEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $title;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.zoom_cancel_staff_html')
            ->text('emails.zoom_cancel_staff_text')
            ->subject($this->title)
            ->with(['data' => $this->data]);
    }
}
