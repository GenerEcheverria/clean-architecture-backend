<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'newCrearSitio.name' => 'required|string',
            'newCrearSitio.backgroundColor' => 'required|string',
            'newCrearSitio.views' => 'required|integer',
            'newCrearSitio.url' => 'required|string',
        ];
    }
}
