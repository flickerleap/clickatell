<?php

if (config('services.clickatell.callback_url')) {
    Route::post('/' . config('services.clickatell.callback_url'), '\FlickerLeap\Clickatell\ClickatellCallback@handle');
}
