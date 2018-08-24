<?php

namespace FlickerLeap\Clickatell;

use FlickerLeap\Clickatell\Exceptions\ConfigError;
use Illuminate\Notifications\Notification;

class ClickatellChannel
{
    /**
     * @var string
     */
    public $to;

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
     * @param $to
     */
    public function to($to)
    {
        $this->to = $to;
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
        $to = $this->to ?? null;

        if (is_null($to)) {
            $to = $notifiable->routeNotificationForClickatell($notification);
        }

        if (is_null($to)) {
            $to = $notifiable->routeNotificationForClickatell($notification->{config('services.clickatell.to')});
        }

        if (is_null($to)) {
            throw ConfigError::configNotSet('services.clickatell.to', 'CLICKATELL_FIELD');
        }

        $message = $notification->toClickatell($notifiable);

        if (is_string($message)) {
            $message = new ClickatellMessage($message);
        }

        $this->clickatell->send($to, $message->getContent());
    }
}
