<?php

namespace App\Http\Controllers\Proprieter;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProprierterRequest;
use App\Models\Bien;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProprieterController extends Controller
{

        /**
 * @OA\Get(
 *     path="/api/v1/bien",
 *     tags={"Bien"},
 *     summary="Liste des Bien",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des utilisateurs récupérée avec succès"
 *     )
 * )
 */
 
    public function getAllProprieter()

    {
        $bien = Bien::all();
        return response()->json(
            [
                "message" => 'tout les biens recuperer avec success',
                'data' => $bien,
                'statusCode' => 200
            ]
        );
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/bien/edit/{id}",
     *     tags={"Bien"},
     *     summary="Update a bien",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bien",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="surface", type="string"),
     *             @OA\Property(property="addresse", type="string"),
     *             @OA\Property(property="code_postal", type="string"),
     *             @OA\Property(property="nbrbatiment", type="string"),
     *             @OA\Property(property="nbrescalier", type="string"),
     *             @OA\Property(property="nbrchambre", type="string"),
     *             @OA\Property(property="numeroporte", type="string"),
     *             @OA\Property(property="zoneStationnement", type="string"),
     *             @OA\Property(property="typemouvement", type="string"),
     *             @OA\Property(property="ungarage", type="string"),
     *             @OA\Property(property="img", type="string"),
     *             @OA\Property(property="unecave", type="string"),
     *             @OA\Property(property="internet", type="string"),
     *             @OA\Property(property="dep_tvecranplat", type="string"),
     *             @OA\Property(property="proprietaire_id", type="string"),
     *             @OA\Property(property="typeBien_id", type="string"),
     *             @OA\Property(property="exist_proxi_restaurant", type="string"),
     *             @OA\Property(property="anneeconstruction", type="string"),
     *             @OA\Property(property="pc_vide_ordure", type="string"),
     *             @OA\Property(property="pc_espace_vert", type="string"),
     *             @OA\Property(property="pc_interphone", type="string"),
     *             @OA\Property(property="nbr_salle_bain", type="string"),
     *             @OA\Property(property="exist_sous_sol", type="string"),
     *             @OA\Property(property="dep_lingemaison", type="string"),
     *             @OA\Property(property="exist_proxi_education", type="string"),
     *             @OA\Property(property="exist_salle_manger", type="string"),
     *             @OA\Property(property="exist_cheminee", type="string"),
     *             @OA\Property(property="pc_antennetv_collective", type="string"),
     *             @OA\Property(property="exist_balcon", type="string"),
     *             @OA\Property(property="exist_proxi_centre_sante", type="string"),
     *             @OA\Property(property="pc_ascenseur", type="string"),
     *             @OA\Property(property="dep_lavevaiselle", type="string"),
     *             @OA\Property(property="statut", type="string"),
     *             @OA\Property(property="slug", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updateProprieter(Request $request, $id)
    {
        $bien = Bien::find($id) ;
        if($bien){
            $validator =   Validator::make($request->all() ,[
                'nom' => 'required|string',
                "surface"=>'required|string' ,
               " addresse"=>'required|string' ,
                "code_postal"=>'required|string' ,
                "nbrbatiment" =>'required|' ,
                "nbrescalier" =>'required|string' ,
                "nbrchambre" =>'required|string' ,
                "numeroporte" =>'required|string' ,
                "zoneStationnement" =>'required|string' ,
                "typemouvement" =>'required|string' ,
                "ungarage" =>'required|string' ,
                "ville_id"=>'required|exists:villes,id' ,
                "img"=>'required|string' ,
                "unecave"=>'required' ,
                "internet"=>'required' ,
                'dep_tvecranplat'=>'required' ,
                'dep_lingemaison'=>'required' ,
                'dep_lavevaiselle'=>'required' ,
                "pc_gardiennage"=>'required' ,
                "pc_interphone"=>'required' ,
                "pc_ascenseur"=>'required' ,
                "pc_vide_ordure"=>'required' ,
                "pc_espace_vert"=>'required' ,
                "pc_chauffage_collective"=>'required' ,
                "pc_eau_chaude_collective"=>'required' ,
                "pc_antennetv_collective"=>'required' ,
                "exist_balcon"=>'required' ,
                "exist_cheminee"=>'required' ,
                "exist_salle_manger"=>'required' ,
                "exist_proxi_education"=>'required' ,
                "exist_sous_sol"=>'required' ,
                "exist_proxi_centre_sante"=>'required' ,
                "exist_proxi_restaurant"=>'required' ,
                "anneeconstruction"=>'required' ,
                'nbr_salle_bain'=>'required' ,
                "typeBien_id"=>'required|exists:typebiens , id' ,
                "statut"=>'required' ,
                "slug"=>'required' ,
                ' proprietaire_id' =>'required|exists:utilisateurs,id',
            ])  ;
            if($validator->fails()){
                return response()->json([
                    'statusCode' => 203,
                    'message' => 'probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
            try {
                $bien->update($validator->validated());
                return response()->json(
                    [
                        "message" => 'bien mis a jour avec success',
                        'data' => $bien,
                        'statusCode' => 200
                    ]
                );
            } catch (Exception $e) {
                //throw $th;
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu',
                    'error' => $e->getMessage()
                ]);
            }
        }else{
            return response()->json([ 
                "statusCode"=>404 ,
                "message"=>"nous  n'avons pas trouver de bien avec cette identifiant" ,
            ]);
        }
        
    }
    /** 
    * @OA\Post(
        *     path="/api/v1/bien/create",
        *     tags={"Bien"},
        *     summary="Create a new Bien",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="surface", type="string"),
     *             @OA\Property(property="addresse", type="string"),
     *             @OA\Property(property="code_postal", type="string"),
     *             @OA\Property(property="nbrbatiment", type="string"),
     *             @OA\Property(property="nbrescalier", type="string"),
     *             @OA\Property(property="nbrchambre", type="string"),
     *             @OA\Property(property="numeroporte", type="string"),
     *             @OA\Property(property="zoneStationnement", type="string"),
     *             @OA\Property(property="typemouvement", type="string"),
     *             @OA\Property(property="ungarage", type="string"),
     *             @OA\Property(property="img", type="string"),
     *             @OA\Property(property="unecave", type="string"),
     *             @OA\Property(property="internet", type="string"),
     *             @OA\Property(property="dep_tvecranplat", type="string"),
     *             @OA\Property(property="proprietaire_id", type="string"),
     *             @OA\Property(property="typeBien_id", type="string"),
     *             @OA\Property(property="exist_proxi_restaurant", type="string"),
     *             @OA\Property(property="anneeconstruction", type="string"),
     *             @OA\Property(property="pc_vide_ordure", type="string"),
     *             @OA\Property(property="pc_espace_vert", type="string"),
     *             @OA\Property(property="pc_interphone", type="string"),
     *             @OA\Property(property="nbr_salle_bain", type="string"),
     *             @OA\Property(property="exist_sous_sol", type="string"),
     *             @OA\Property(property="dep_lingemaison", type="string"),
     *             @OA\Property(property="exist_proxi_education", type="string"),
     *             @OA\Property(property="exist_salle_manger", type="string"),
     *             @OA\Property(property="exist_cheminee", type="string"),
     *             @OA\Property(property="pc_antennetv_collective", type="string"),
     *             @OA\Property(property="exist_balcon", type="string"),
     *             @OA\Property(property="exist_proxi_centre_sante", type="string"),
     *             @OA\Property(property="pc_ascenseur", type="string"),
     *             @OA\Property(property="dep_lavevaiselle", type="string"),
     *             @OA\Property(property="statut", type="string"),
     *             @OA\Property(property="slug", type="string"),
        *         )
        *     ),
        *     @OA\Response(response="201", description="Bien created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */

    public function registerProprieter(Request $request)
    {

        $validator =   Validator::make($request->all() ,[
            'nom' => 'required|string',
            "surface"=>'required|string' ,
           " addresse"=>'required|string' ,
            "code_postal"=>'required|string' ,
            "nbrbatiment" =>'required|' ,
            "nbrescalier" =>'required|string' ,
            "nbrchambre" =>'required|string' ,
            "numeroporte" =>'required|string' ,
            "zoneStationnement" =>'required|string' ,
            "typemouvement" =>'required|string' ,
            "ungarage" =>'required|string' ,
            "ville_id"=>'required|exists:villes,id' ,
            "img"=>'required|string' ,
            "unecave"=>'required' ,
            "internet"=>'required' ,
            'dep_tvecranplat'=>'required' ,
            'dep_lingemaison'=>'required' ,
            'dep_lavevaiselle'=>'required' ,
            "pc_gardiennage"=>'required' ,
            "pc_interphone"=>'required' ,
            "pc_ascenseur"=>'required' ,
            "pc_vide_ordure"=>'required' ,
            "pc_espace_vert"=>'required' ,
            "pc_chauffage_collective"=>'required' ,
            "pc_eau_chaude_collective"=>'required' ,
            "pc_antennetv_collective"=>'required' ,
            "exist_balcon"=>'required' ,
            "exist_cheminee"=>'required' ,
            "exist_salle_manger"=>'required' ,
            "exist_proxi_education"=>'required' ,
            "exist_sous_sol"=>'required' ,
            "exist_proxi_centre_sante"=>'required' ,
            "exist_proxi_restaurant"=>'required' ,
            "anneeconstruction"=>'required' ,
            'nbr_salle_bain'=>'required' ,
            "typeBien_id"=>'required|exists:typebiens , id' ,
            "statut"=>'required' ,
            "slug"=>'required' ,
            ' proprietaire_id' =>'required|exists:utilisateurs,id',
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
            $bien =  Bien::create($validator->validated());
            return response()->json(
                [
                    "message" => 'bien ajouter avec success',
                    'data' => $bien,
                    'statusCode' => 200
                ]
            );
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ]);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/v1/bien/show/{id}",
     *     tags={"Bien"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Bien",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showProprieter($id)
    {

            $bienId = Bien::find($id) ;
            if($bienId){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"bien  recuperer en particulier  avec success", 
                    'data'=>$bienId
            ]) ;
        }else{
            return   response()->json( [
                'statusCode'=>203,
                    'message'=>"nous n'avons pas trouver de  bien avec l'identifiant unique passer", 
            ]) ;
        }
    
        
}

 /**
 * @OA\Delete(
 *     path="/api/v1/bien/delete/{id}",
 *     tags={"Bien"},
 *     summary="Delete a Bien",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="204", description="User deleted"),
 *     @OA\Response(response="404", description="User not found")
 * )
 */
public function deleleBien(string $id)
{
    $bien = Bien::find($id) ;
    if($bien){
        $bien->deleted_at = Carbon::now() ;
        return response()->json([
            'message'=>"bien suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de bien avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
