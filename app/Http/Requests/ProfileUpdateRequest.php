<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255', 
                Rule::unique(User::class)->ignore($this->user()->id)
            ],
        ];
    
        // Adicionando validação condicional para professores
        if ($this->user()->role === 'professor') {
            $rules['disciplinas'] = ['nullable', 'array'];
            $rules['disciplinas.*'] = ['exists:disciplinas,id'];
        }
    
        return $rules;
    }    
}
