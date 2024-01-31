<?php
namespace App\Http\Requests\Backend;

use App\Http\Requests\Request as Request;

class StoreZoneTypeRequest extends Request {

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
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.min'=>'The amount should be greater than 0'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'  => 'required|max:255',
            'amount'      => 'required|numeric|min:0',

        ];

    }
}