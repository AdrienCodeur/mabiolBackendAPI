<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceRequest extends FormRequest
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
             'proprietaire_id'=>'required' ,
             'bien_id'=>'required' ,
             'typePaiment_id'=>'required' ,
             'autre_typepaiment'=>'required' ,
             'datepaiment'=>'required',
             'montant'=>'required',
             'statut'=>'required' ,
             'periode'=>'required' ,
             'commentaire'=>'required' ,
             'frequence'=>'required' ,
             'typeFinance_id'=>'required' ,
             'slug'=>'required' ,
        ];
    }
}
