<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        return [
            'descripcion' => 'string|nullable',
            'imagen' => 'file|image|required_if:descripcion,null',
        ];
    }

    public function messages()
    {
        if(app()->getLocale() === 'en'){
            return [
                'imagen.required_if' => 'Una publicación necesita al menos una imagen.',
            ];
        }else{
            return [
                'imagen.required_if' => 'A post needs at least an image.',
            ];
        }


    }
}
