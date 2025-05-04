<?php

declare(strict_types=1);

namespace Modules\Contact\Infrastructure\Adapter\In\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListContactsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q'         => ['nullable','string'],
            'page'      => ['nullable','integer','min:1'],
            'per_page'  => ['nullable','integer','min:1','max:100'],
            'sort'      => ['nullable','in:name,cpf'],
            'dir'       => ['nullable','in:asc,desc'],
        ];
    }
}
