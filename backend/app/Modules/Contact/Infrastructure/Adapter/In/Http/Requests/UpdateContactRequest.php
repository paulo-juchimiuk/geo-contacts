<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\In\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => ['sometimes','string','max:255'],
            'cpf'       => ['sometimes','string','max:14'],
            'phone'     => ['sometimes','string','max:20'],
            'address'   => ['sometimes','string','max:255'],
            'latitude'  => ['sometimes','numeric'],
            'longitude' => ['sometimes','numeric'],
        ];
    }
}
