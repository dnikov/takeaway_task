<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Consumer as ConsumerModel;

class Consumer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @TODO Add some logic if we had an logged in user */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'between:4,40',
            'age' => 'integer|between:14,99',
            'city' => 'in:' . implode(',', ConsumerModel::getAvailableCities())
        ];
    }
}
