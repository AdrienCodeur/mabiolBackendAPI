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
 *     path="/api/v1/proprieter",
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
        $bien = Bien::whereNull("deleted_at")->get();
        return response()->json(
            [
                "message" => 'tout les biens recuperer avec success',
                'data' => $bien,
                'statusCode' => 200
            ]
        );
    }

    /**
 * @OA\Put(
 *     path="/api/v1/proprieter/edit/{id}",
 *     tags={"Bien"},
 *     summary="Mettre à jour un bien",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID du bien",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom", "adresse", "code_postal", "proprietaire_id", "typeBien_id"},
 *             @OA\Property(property="nom", type="string"),
 *             @OA\Property(property="surface", type="number"),
 *             @OA\Property(property="addresse", type="string",example="string"),
 *             @OA\Property(property="code_postal", type="number"),
 *             @OA\Property(property="nbrbatiment", type="number"),
 *             @OA\Property(property="nbrescalier", type="number"),
 *             @OA\Property(property="nbrchambre", type="number"),
 *             @OA\Property(property="numeroporte", type="number"),
 *             @OA\Property(property="zoneStationnement", type="string"),
 *             @OA\Property(property="typemouvement", type="string"),
 *             @OA\Property(property="ungarage", type="boolean"),
 *             @OA\Property(property="unecave", type="boolean"),
 *             @OA\Property(property="internet", type="boolean"),
 *             @OA\Property(property="ville_id", type="boolean"),
 *             @OA\Property(property="dep_tvecranplat", type="boolean"),
 *             @OA\Property(property="tv_ecran_plat", type="boolean"),
 *             @OA\Property(property="proprietaire_id", type="number" ,example="1"),
 *             @OA\Property(property="typeBien_id", type="number"),
 *             @OA\Property(property="exist_proxi_restaurant", type="boolean"),
 *             @OA\Property(property="anneeconstruction", type="string"),
 *             @OA\Property(property="pc_vide_ordure", type="boolean"),
 *             @OA\Property(property="pc_espace_vert", type="boolean"),
 *             @OA\Property(property="pc_interphone", type="boolean"),
 *             @OA\Property(property="nbr_salle_bain", type="number"),
 *             @OA\Property(property="exist_sous_sol", type="boolean"),
 *             @OA\Property(property="pc_chauffage_collective", type="boolean"),
 *             @OA\Property(property="pc_eau_chaude_collective", type="boolean"),
 *             @OA\Property(property="dep_lingemaison", type="boolean"),
 *             @OA\Property(property="pc_gardiennage", type="boolean"),
 *             @OA\Property(property="exist_proxi_education", type="boolean"),
 *             @OA\Property(property="exist_salle_manger", type="boolean"),
 *             @OA\Property(property="exist_cheminee", type="boolean"),
 *             @OA\Property(property="pc_antennetv_collective", type="boolean"),
 *             @OA\Property(property="exist_balcon", type="boolean"),
 *             @OA\Property(property="exist_proxi_centre_sante", type="boolean"),
 *             @OA\Property(property="pc_ascenseur", type="boolean"),
 *             @OA\Property(property="dep_lavevaiselle", type="boolean"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="Bien mis à jour"),
 *     @OA\Response(response="404", description="Bien non trouvé"),
 *     @OA\Response(response="422", description="Erreur de validation")
 * )
 */


    public function updateProprieter(Request $request, $id)
    {
        $bien = Bien::find($id) ;
        if($bien){
            $validator =   Validator::make($request->all() ,[
                'nom' => 'required|string',
                "surface"=>'required|integer' ,
               "addresse"=>'required|string' ,
                "code_postal"=>'required|integer' ,
                "nbrbatiment" =>'required|integer' ,
                "nbrescalier" =>'required|integer' ,
                "nbrchambre" =>'required|integer' ,
                "numeroporte" =>'required|integer' ,
                "zoneStationnement" =>'required|string' ,
                "typemouvement" =>'required|string' ,
                "ungarage" =>'required|boolean' ,
                "ville_id"=>'required|exists:villes,id' ,
                // "img"=>'required|string|array' ,
                "unecave"=>'required|boolean' ,
                "internet"=>'required|boolean' ,
                'dep_tvecranplat'=>'required|boolean' ,
                'dep_lingemaison'=>'required|boolean' ,
                'dep_lavevaiselle'=>'required|boolean' ,
                "pc_gardiennage"=>'required|boolean' ,
                "pc_interphone"=>'required|boolean' ,
                "pc_ascenseur"=>'required|boolean' ,
                "pc_vide_ordure"=>'required|boolean' ,
                "pc_espace_vert"=>'required|boolean' ,
                "pc_chauffage_collective"=>'required|boolean' ,
                "pc_eau_chaude_collective"=>'required|boolean' ,
                "pc_antennetv_collective"=>'required|boolean' ,
                "exist_balcon"=>'required' ,
                "exist_cheminee"=>'required' ,
                "exist_salle_manger"=>'required|boolean' ,
                "exist_proxi_education"=>'required|boolean' ,
                "exist_sous_sol"=>'required|boolean' ,
                "exist_proxi_centre_sante"=>'required|boolean' ,
                "exist_proxi_restaurant"=>'required|boolean' ,
                "anneeconstruction"=>'required' ,
                'nbr_salle_bain'=>'required|integer' ,
                "typeBien_id"=>'required|exists:typebiens,id' ,
                'proprietaire_id' =>'required|exists:utilisateurs,id',
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
        *     path="/api/v1/proprieter/create",
        *     tags={"Bien"},
        *     summary="Create a new Bien",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="surface", type="string" ,example="300"),
     *             @OA\Property(property="addresse", type="string"),
     *             @OA\Property(property="code_postal", type="number"),
     *             @OA\Property(property="nbrbatiment", type="number"),
     *             @OA\Property(property="nbrescalier", type="number"),
     *             @OA\Property(property="nbrchambre", type="number"),
     *             @OA\Property(property="ville_id", type="number" ,example="1"),
     *             @OA\Property(property="numeroporte", type="number"),
     *             @OA\Property(property="zoneStationnement", type="string"),
     *             @OA\Property(property="typemouvement", type="string"),
     *             @OA\Property(property="ungarage", type="boolean"),
     *             @OA\Property(property="unecave", type="boolean"),
     *             @OA\Property(property="internet", type="boolean"),
     *             @OA\Property(property="dep_tvecranplat", type="boolean"),
     *             @OA\Property(property="proprietaire_id", type="number" ,example="2"),
     *             @OA\Property(property="typeBien_id", type="number" ,example="1"),
     *             @OA\Property(property="exist_proxi_restaurant", type="boolean"),
     *             @OA\Property(property="anneeconstruction", type="string"),
     *             @OA\Property(property="pc_vide_ordure", type="boolean"),
     *             @OA\Property(property="pc_espace_vert", type="boolean"),
     *             @OA\Property(property="pc_eau_chaude_collective", type="boolean"),
     *             @OA\Property(property="pc_chauffage_collective", type="boolean"),
     *             @OA\Property(property="pc_interphone", type="boolean"),
     *             @OA\Property(property="nbr_salle_bain", type="boolean"),
     *             @OA\Property(property="exist_sous_sol", type="boolean"),
     *             @OA\Property(property="dep_lingemaison", type="boolean"),
     *             @OA\Property(property="exist_proxi_education", type="boolean"),
     *             @OA\Property(property="exist_salle_manger", type="boolean"),
     *             @OA\Property(property="exist_cheminee", type="boolean"),
     *             @OA\Property(property="pc_gardiennage", type="boolean"),
     *             @OA\Property(property="pc_antennetv_collective", type="boolean"),
     *             @OA\Property(property="exist_balcon", type="boolean"),
     *             @OA\Property(property="exist_proxi_centre_sante", type="boolean"),
     *             @OA\Property(property="pc_ascenseur", type="boolean"),
     *             @OA\Property(property="dep_lavevaiselle", type="boolean"),
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
           "addresse"=>'required|string' ,
            "code_postal"=>'required|integer' ,
            "nbrbatiment" =>'required|integer' ,
            "nbrescalier" =>'required|integer' ,
            "nbrchambre" =>'required|integer' ,
            "numeroporte" =>'required|integer' ,
            "zoneStationnement" =>'required|string' ,
            "typemouvement" =>'required|string' ,
            "ungarage" =>'required|boolean' ,
            "ville_id"=>'required|exists:villes,id' ,
            // "img"=>'required|string' ,
            "unecave"=>'required' ,
            "internet"=>'required' ,
            'dep_tvecranplat'=>'required' ,
            'dep_lingemaison'=>'required' ,
            'dep_lavevaiselle'=>'required' ,
            "pc_gardiennage"=>'required' ,
            "pc_interphone"=>'required' ,
            "pc_ascenseur"=>'required|boolean' ,
            "pc_vide_ordure"=>'required|boolean' ,
            "pc_espace_vert"=>'required|boolean' ,
            "pc_chauffage_collective"=>'required|boolean' ,
            "pc_eau_chaude_collective"=>'required|boolean' ,
            "pc_antennetv_collective"=>'required|boolean' ,
            "exist_balcon"=>'required' ,
            "exist_cheminee"=>'required|boolean' ,
            "exist_salle_manger"=>'required|boolean' ,
            "exist_proxi_education"=>'required|boolean' ,
            "exist_sous_sol"=>'required|boolean' ,
            "exist_proxi_centre_sante"=>'required|boolean' ,
            "exist_proxi_restaurant"=>'required|boolean' ,
            "anneeconstruction"=>'required' ,
            'nbr_salle_bain'=>'required|integer' ,
            "typeBien_id"=>'required|exists:typebiens,id' ,
            'proprietaire_id' =>'required|exists:utilisateurs,id',
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
            $dataBien= $validator->validated() ;
            $dataBien['slug'] = $request->nom ;
            $dataBien['statut'] = 'actif';
            $dataBien['img'] =json_encode(['image1' ,'image2' ,'image3']);
            $bien =  Bien::create($dataBien);
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
            ] ,500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/v1/proprieter/show/{id}",
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
                'statusCode'=>404,
                    'message'=>"nous n'avons pas trouver de  bien avec l'identifiant unique passer", 
            ],404) ;
        }
    
        
}

 /**
 * @OA\Delete(
 *     path="/api/v1/proprieter/delete/{id}",
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
public function deleteProprieter(string $id)
{
    $bien = Bien::find($id) ;
    if($bien){
        $bien->deleted_at = Carbon::now() ;
        $bien->save() ;
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

    /**
     * @OA\Get(
     *     path="/api/v1/proprieter/showForProprietaire/{proprietaire_id}",
     *     tags={"Bien"},
     *     summary="listes de tout les biens d'un proprietaire",
     *     @OA\Parameter(
     *         name="proprietaire_id",
     *         in="path",
     *         required=true,
     *         description=" id du Bien",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */

     public function  getAllProprieterForProprietaire($proprietaire_id)
     {

        $bienId = Bien::where("proprietaire_id" ,$proprietaire_id)->get();
        if($bienId){
        return   response()->json( [
            'statusCode'=>200,
                'message'=>"biens recuperer avec success pour le proprietaire en question", 
                'data'=>$bienId
        ]) ;
    }else{
        return   response()->json( [
            'statusCode'=>404,
                'message'=>"nous n'avons pas trouver de  bien avec l'identifiant du proprietaire passer", 
        ],404) ;
    }
     }
}
