<?php

namespace FlickerLeap\Clickatell;

use FlickerLeap\Clickatell\Exceptions\ConfigError;
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
        if (!$to = $notifiable->routeNotificationForClickatell($notification)) {
            if (!$to = config('services.clickatell.to')) {
                throw ConfigError::configNotSet('services.clickatell.to', 'CLICKATELL_FIELD');
            }
        }

        $message = $notification->toClickatell($notifiable);

        if (is_string($message)) {
            $message = new ClickatellMessage($message);
        }

        $this->clickatell->send($to, $message->getContent());
    }
}
