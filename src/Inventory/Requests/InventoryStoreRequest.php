<?php

namespace Src\Inventory\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:IN,OUT',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'nullable|string|max:100',
            'note'       => 'nullable|string',
        ];
    }
}
