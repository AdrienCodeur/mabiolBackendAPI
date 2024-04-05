<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtilisateurRequest extends FormRequest
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
            'email' => 'required|string|email|unique:Utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'sexe' => 'required|string',
            'login' => 'required|string',
            'statut' => 'required|string',
            'slug' => 'required|string',
            'type_user_id' => 'required|exists:type_users,id'
        ];
    }
}
