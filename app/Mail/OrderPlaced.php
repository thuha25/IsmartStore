<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $orderID;
    public $orderDetails;
    public function __construct($orderID, $orderDetails)
    {
        $this->orderID = $orderID;
        $this->orderDetails = $orderDetails;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order_placed')
            ->from('ismart@gmail.com')
            ->subject('Xác nhận đặt hàng')
            ->with([
                'order' => DB::table('orders')->where('idDH', $this->orderID)->first(),
                'orderDetails' => DB::table('order_details')->where('idDH', $this->orderID)->get(),
            ]);
    }
}
