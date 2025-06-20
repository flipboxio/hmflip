<?php

/**
 * @package YooKassaRequest
 * @author TechVillage <support@techvill.org>
 * @contributor Muhammed Kamrul Hasan <[kamrul.techvill@gmail.com]>
 * @created 18-01-25
 */

namespace Modules\YooKassa\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YooKassaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return config('yookassa.validation')['rules'];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Attributes custom names
     *
     * @return array
     */
    public function attributes()
    {
        return config('yookassa.validation')['attributes'];
    }
}
