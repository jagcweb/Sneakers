<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class AfterOrder extends Mailable {

    use Queueable,
        SerializesModels;

    public $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {


        return $this->view('mail.after-order')
                        ->subject('Thanks for your purchase');
    }

}
