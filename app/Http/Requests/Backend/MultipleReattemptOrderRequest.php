<?php
namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class MultipleReattemptOrderRequest extends Request {

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

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = $this->all();

        $rules = [
            'data'       => 'required|present|array'
        ];


        return $rules;
    }
}