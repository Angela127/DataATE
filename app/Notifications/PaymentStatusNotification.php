<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $rentalId;
    protected $reason;
    protected $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $rentalId, $reason = null, $actionUrl = null)
    {
        $this->status = $status;
        $this->rentalId = $rentalId;
        $this->reason = $reason;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = 'Your payment has been updated.';
        
        if ($this->status === 'verified') {
            $message = 'Your payment has been verified! Click to proceed to pickup.';
        } elseif ($this->status === 'failed') {
            if ($this->reason === 'Incorrect Amount') {
                $message = 'Payment failed: Incorrect Amount. Tap here for refund.';
            } elseif ($this->reason === 'Invalid Account') {
                $message = 'Payment failed: Invalid Account. Tap here to go to homepage.';
            } else {
                $message = 'Your payment verification failed.';
                if ($this->reason) {
                    $message .= ' Reason: ' . $this->reason;
                } else {
                     $message .= ' Please contact support.';
                }
            }
        }

        // Use custom actionUrl if provided, else default logic
        $url = $this->actionUrl;
        if (!$url) {
             $url = $this->status === 'verified' ? route('booking.pickup') : route('mainpage');
        }

        return [
            'status' => $this->status,
            'rental_id' => $this->rentalId,
            'message' => $message,
            'action_url' => $url,
        ];
    }
}
