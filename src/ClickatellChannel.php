<?php

namespace FlickerLeap\Clickatell;

use FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class ClickatellChannel
{
    /**
     * @var \FlickerLeap\Clickatell\ClickatellClient
     */
    protected $clickatell;

    /**
     * ClickatellChannel constructor.
     *
     * @param \FlickerLeap\Clickatell\ClickatellClient $clickatell
     */
    public function __construct(ClickatellClient $clickatell)
    {
        $this->clickatell = $clickatell;
    }

    /**
     * Send the notification
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationForClickatell($notification) ?? null;

        if (is_null($to) && config('services.clickatell.to')) {
            $to = $notifiable->routeNotificationForClickatell($notification->{config('services.clickatell.to')});
        }

        $message = $notification->toClickatell($notifiable);

        if (!is_null($message->getTo())) {
            $to = $message->getTo();
        }

        if (is_string($message)) {
            $message = new ClickatellMessage($message);
        }

        if (is_null($to)) {
            throw CouldNotSendNotification::recipientNotSet();
        }

        $this->clickatell->send($to, $message->getContent());
    }
}
