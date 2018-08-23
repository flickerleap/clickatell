<?php

namespace FlickerLeap\Clickatell;

use App\Http\Controllers\Controller;
use FlickerLeap\Clickatell\Requests\Callback;
use Illuminate\Support\Facades\DB;

class ClickatellCallback extends Controller
{
    /**
     * @param \FlickerLeap\Clickatell\Requests\Callback $request
     */
    public function handle(Callback $request)
    {
        $entry = DB::table(config('services.clickatell.log_table'))->where('message_id', $request->input('messageId'));

        switch ($request->input('status')) {
            case 'DELIVERED_TO_GATEWAY':
                $entry->update(['DELIVERED_TO_GATEWAY' => now()]);
                break;
            case 'RECEIVED_BY_RECIPIENT':
                $entry->update(['RECEIVED_BY_RECIPIENT' => now()]);
                break;
        }
    }
}
