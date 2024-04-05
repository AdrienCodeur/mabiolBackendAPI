<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratRequest extends FormRequest
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
             'duree'=>'required|string' ,
             'dateDeput'=>'required|string', 
             'montantLoyer'=>'required', 
             'charge'=>'required', 
             'typeCharge_id'=>'required', 
             'periode_paiment'=>'required', 
             'jourpaiment'=>'required', 
             'typePaiement_id'=>'required', 
             'clause_revision_loyer'=>'required', 
             'indice_reference'=>'required', 
             'description_bail'=>'required', 
             'clauseparticuliere'=>'required', 
             'garantsolidaire'=>'required', 
             'aut_paiement'=>'required', 
             'aut_avis_echeance'=>'required', 
             'aut_quittance'=>'required', 
             'typeContrat_id'=>'required', 
             'statut'=>'required', 
             'slug'=>'required', 
             'proprietaire_id'=>'required', 
             'locataire_id'=>'required', 
             'location_id'=>'required', 
        ];
    }
}
