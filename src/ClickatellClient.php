<?php

namespace FlickerLeap\Clickatell;

use Clickatell\ClickatellException;
use Clickatell\Rest;
use FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification;

class ClickatellClient
{
    /**
     * @var \Clickatell\Rest
     */
    private $clickatell;

    /**
     * ClickatellClient constructor.
     *
     * @param \Clickatell\Rest $clickatellRest
     */
    public function __construct(Rest $clickatellRest)
    {
        $this->clickatell = $clickatellRest;
    }

    /**
     * @param array $to
     * @param $message
     * @throws \FlickerLeap\Clickatell\Exceptions\CouldNotSendNotification
     */
    public function send($to, $message)
    {
        if (config('app.env') != 'local') {
            try {
                $response = $this->clickatell->sendMessage(['to' => [$to], 'content' => $message]);
            } catch (ClickatellException $e) {
                throw CouldNotSendNotification::serviceNotReached($e->getMessage());
            }

            if ($response == null) {
                throw CouldNotSendNotification::noResponse();
            }

            $this->handleProviderResponses($response, $to, $message);
        } else {
            info('Clickatell test sent. To: ' . $to . ' Message: ' . $message);
        }
    }

    /**
     * @param array $responses
     * @param array $to
     * @param $message
     */
    protected function handleProviderResponses(array $responses, $to, $message)
    {
        collect($responses)->each(function ($response) use ($to, $message) {
            $code = (int)$response['errorCode'];
            $error = $response['error'] ? (string)$response['error'] : 'SUCCESS';
            $this->track($to, $message, $code, $error, $response['apiMessageId']);

            if ($code > 0) {
                throw CouldNotSendNotification::serviceRespondedWithAnError($error, $code);
            }
        });
    }

    /**
     * @param $to
     * @param $content
     * @param $code
     * @param $status
     * @param $id
     */
    private function track($to, $content, $code, $status, $id)
    {
        if (config('services.clickatell.track') == true
            && \Illuminate\Support\Facades\Schema::hasTable(config('services.clickatell.tracking_table'))) {
            \Illuminate\Support\Facades\DB::table(config('services.clickatell.tracking_table'))->insert(
                [
                    'to' => $to,
                    'content' => $content,
                    'code' => $code,
                    'status' => $status,
                    'message_id' => $id,
                ]
            );
        }
    }
}
