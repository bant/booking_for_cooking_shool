<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomReservationStaffEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $classification;
    protected $title;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($classification, $title, $data)
    {
        $this->classification = $classification;
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
        switch ($this->classification) {
            case 'hon_yoyaku':      /* 支払い済み */
                return $this->text('emails.zoom_hon_reservation_staff_plane')
                    //                    ->view('emails.zoom_hon_reservation_staff')
                    ->subject($this->title)
                    ->with(['data' => $this->data]);

            case 'kari_yoyaku':        /* 仮払い */
                return $this->text('emails.zoom_kari_reservation_staff_plane')
                    //                    ->view('emails.zoom_kari_reservation_staff')
                    ->subject($this->title)
                    ->with(['data' => $this->data]);

            case 'kakutei':      /* キャンセル待ち */
                return $this->text('emails.zoom_kakutei_reservation_staff_plane')
                    //                    ->view('emails.zoom_kakutei_reservation_staff')
                    ->subject($this->title)
                    ->with(['data' => $this->data]);

            case 'cancel_machi':      /* キャンセル待ち */
                return $this->text('emails.zoom_cancel_reservation_staff_plane')
                    //                    ->view('emails.zoom_cancel_reservation_staff')
                    ->subject($this->title)
                    ->with(['data' => $this->data]);
        }
    }
}
