Install
```bash
composer require flickerleap/clickatell
```

Add to .ENV
```dotenv
CLICKATELL_TOKEN=
```

Optional .ENV
```dotenv
CLICKATELL_FIELD=
CLICKATELL_LOG=
CLICKATELL_LOG_TABLE=
CLICKATELL_CALLBACK_URL=
CLICKATELL_USERNAME=
CLICKATELL_PASSWORD=
```

Publish
```bash
php artisan vendor:publish --provider="FlickerLeap\Clickatell\ClickatellServiceProvider"
```

Migrate (If logging)
```bash
php artisan migrate
```
