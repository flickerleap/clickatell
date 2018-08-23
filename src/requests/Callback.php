<?php

namespace FlickerLeap\Clickatell\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Callback extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!config('services.clickatell.username')) {
            throw \FlickerLeap\Clickatell\Exceptions\ConfigError::configNotSet(
                'services.clickatell.username',
                'CLICKATELL_USERNAME'
            );
        }
        if (!config('services.clickatell.password')) {
            throw \FlickerLeap\Clickatell\Exceptions\ConfigError::configNotSet(
                'services.clickatell.password',
                'CLICKATELL_PASSWORD'
            );
        }

        if ($this->headers->get('php-auth-user') == config('services.clickatell.username')
            && $this->headers->get('php-auth-pw') == config('services.clickatell.password')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
