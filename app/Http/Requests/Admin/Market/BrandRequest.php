<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')){
            return [
                'original_name' => 'required|max:120|min:2',
                'persian_name' => 'required|max:500|min:2',
                'status' => 'required|numeric|in:0,1',
                'logo' => 'required|image|mimes:png,jpg,jpeg,gif',
                'tags' => 'required',
            ];
        }
        else{
            return [
                'original_name' => 'required|max:120|min:2',
                'persian_name' => 'required|max:500|min:2',
                'status' => 'required|numeric|in:0,1',
                'logo' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'tags' => 'required',
            ];
        }
    }
}
