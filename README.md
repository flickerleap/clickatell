# Clickatell notifications channel
This package implements Clickatell as a Laravel notification channel.

We drew a lot of inspiration from [laravel-notification-channels/clickatell](https://github.com/laravel-notification-channels/clickatell)


## Contents

- [Installation](#installation)
    - [.env](#.env)
    - [Publish](#publish)
- [Configuration](#configuration)
    - [Default to](#default-to)
    - [Tracking](#tracking)
    - [Callback](#callback)
- [Usage](#usage)
    - [Notifiable](#notifiable)
    - [Notification](#notification)
    - [To](#to)
    - [Call](#call)
- [Testing](#testing)
- [Tests](#tests)
- [Credits](#credits)

## Installation
```bash
composer require flickerleap/clickatell
```

### .env
```dotenv
CLICKATELL_TOKEN=
```

### Publish
```bash
php artisan vendor:publish --provider="FlickerLeap\Clickatell\ClickatellServiceProvider"
```

## Configuration

### Default to
```dotenv
CLICKATELL_FIELD=
```
- `CLICKATELL_FIELD` - The default field to use for the `to` if the `routeNotificationForClickatell()` method is not implemented on the notifiable class.


### Tracking

Optional tracking logs the send status from Clickatell. `php artisan migrate` needs to be run once enabled.
```dotenv
CLICKATELL_TRACK=
CLICKATELL_TRACKING_TABLE=
```
- `CLICKATELL_TRACK` - Tracking true of false.
- `CLICKATELL_TRACKING_TABLE` - Optional table name for tracking.

### Callback

Optionally, with delivery notifications enabled, set the credentials and URL here. Tracking needs to be enabled. A value of `/clickatellCallback` would be accessed at `https://mysite.com/clickatellCallback`
```dotenv
CLICKATELL_CALLBACK_URL=
CLICKATELL_USERNAME=
CLICKATELL_PASSWORD=
```

- `CLICKATELL_CALLBACK_URL` - Callback URL for message delivery updates.
- `CLICKATELL_USERNAME` - Callback credentials.
- `CLICKATELL_PASSWORD` - Callback credentials.

## Usage

### Notifiable

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    /**
     * Route notifications for the clickatell channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForClickatell($notification)
    {
        return $this->mobile;
    }

```

### Notification
```php
<?php

namespace App\Notifications;

use FlickerLeap\Clickatell\ClickatellChannel;
use FlickerLeap\Clickatell\ClickatellMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SMSUser extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ClickatellChannel::class];
    }

    /**
     * @param $notifiable
     * @return \FlickerLeap\Clickatell\ClickatellMessage
     */
    public function toClickatell($notifiable)
    {
        $content = 'My message.';

        return (new ClickatellMessage())->content($content);
    }

}
```

### To

Optionally the `to` field can be dynamically changed per call by specifying `->to()`

```php
    /**
     * @param $notifiable
     * @return \FlickerLeap\Clickatell\ClickatellMessage
     */
    public function toClickatell($notifiable)
    {
        $content = 'My message.';

        return (new ClickatellMessage())->to($notifiable->beneficiary_number)
            ->content($content);
    }
```

### Call

```php
$user->notify(new SMSUser());
```

## Testing
If `APP_ENV` is set to local, laravel log entries will be created.

## Tests
TODO

## Credits

- [laravel-notification-channels](https://github.com/laravel-notification-channels/clickatell)
- [etiennemarais](https://github.com/etiennemarais)
- [arcturial](https://github.com/arcturial)
    - For the [Clickatell Client implementation](https://github.com/arcturial/clickatell) which is leveraged on this package.
