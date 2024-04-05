<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProprierterRequest extends FormRequest
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
             'nom'=>'required|string|min:5' ,
             'nbrchambre'=>'required|string' ,
             'surface'=>'required|string' ,
             'proprietaire_id'=>'required|string' ,
             'ville_id'=>'required|string' ,
             'adresse'=>'required|string' ,
             'nbretage'=>'required|string' ,
             'nbrescalier'=>'required|string' ,
             'numeroporte'=>'required|string' ,
             'codepostal'=>'required|string' ,
             'nbrbatiment'=>'required|string' ,
             'zoneStationnement'=>'required|string' ,
             'ungarage'=>'required' ,
             'unecave'=>'required' ,
             'internet'=>'required' ,
             'dep_tvecranplat'=>'required' ,
             'dep_lingemaison'=>'required' ,
             'dep_lavevaiselle'=>'required' ,
             'pc_gardiennage'=>'required' ,
             'pc_interphone'=>'required' ,
             'pc_ascenseur'=>'required' ,
             'pc_vide_ordure'=>'required' ,
             'pc_espace_vert'=>'required' ,
             'pc_chauffage_collective'=>'required' ,
             'pc_antennetv_collective'=>'required' ,
             'exist_balcon'=>'required|boolean' ,
             'exist_cheminee'=>'required|boolean' ,
             'exist_salle_manger'=>'required|boolean' ,
             'exist_proxi_education'=>'required|boolean' ,
             'exist_sous_sol'=>'required|boolean' ,
             'exist_proxi_centre_sante'=>'required|boolean' ,
             'exist_proxi_retaurant'=>'required|boolean' ,
             'exist_proxi_retaurant'=>'required|boolean' ,
             'anneecontruction'=>'required|string' ,
             'nbr_salle_bain'=>'required|string' ,
             'typeBien_id'=>'required|string' ,
             'statut'=>'required|string' ,
             'slug'=>'required|string' ,
             'img'=>'required|string' ,
        ];
    }
}
