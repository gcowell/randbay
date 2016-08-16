<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SupportEvidenceRequest extends Request
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
        return
            [
                //TODO size constraints
                'evidence-image1'  => 'required_without_all:evidence-image2,evidence-image3,evidence-image4|mimes:jpeg,jpg,bmp,png',
                'evidence-image2'  => 'required_without_all:evidence-image1,evidence-image3,evidence-image4|mimes:jpeg,jpg,bmp,png',
                'evidence-image3'  => 'required_without_all:evidence-image2,evidence-image1,evidence-image4|mimes:jpeg,jpg,bmp,png',
                'evidence-image4'  => 'required_without_all:evidence-image2,evidence-image3,evidence-image1|mimes:jpeg,jpg,bmp,png',
            ];
    }
}
