<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'ruc' => 'required|string|size:11|unique:suppliers',
            'email' => 'required|email|max:100',
            'address' => 'required|string|max:100',
            'state' => 'required|string|in:activo,inactivo',
        ];
    }
}
