<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Adapter\In\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupCepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cep' => ['required', 'regex:/^\d{8}$/'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cep' => $this->route('cep'),
        ]);
    }
}
