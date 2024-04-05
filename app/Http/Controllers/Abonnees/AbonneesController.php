<?php

namespace App\Http\Controllers\Abonnees;

use App\Models\Abonnee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbonneeRequest;
use Carbon\Carbon;
use Exception ;
use Illuminate\Support\Facades\Validator;


class AbonneesController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/abonnee",
 *     tags={"Abonnee"},
 *     summary="Liste des abonnees",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des abonnees récupérée avec succès"
 *     )
 * )
 */
    public function getAllAbonnee()
    {
        $bien = Abonnee::all();
        return response()->json(
            [
                "message" => 'tout les abonnees recuperer avec success',
                'data' => $bien,
                'statusCode' => 200
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *//**
 * @OA\Put(
 *     path="/api/abonnee/edit/{id}",
 *     tags={"Abonnee"},
 *     summary="Update a contrat",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the contrat",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
*         @OA\JsonContent(
 *             required={"statut", "slug", "utilisateur_id" ,"typeabonnement_id"},
 *             @OA\Property(property="statut", type="string", example="En cours"),
 *             @OA\Property(property="slug", type="string", example="slug"),
 *             @OA\Property(property="utilisateur_id", type="string", example="2")
 *         )
 *     ),
 *     @OA\Response(response="200", description="abonnee updated"),
 *     @OA\Response(response="404", description="abonnee not found"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
    public function updateAbonnee(Request $request,$id)
    {

        $validator =   Validator::make($request->all() ,[
            'statut' => 'required|string',
            'slug' => 'required|string',
            'utilisateur_id' => 'required|exists:utilisateurs,id' ,
            'typeabonnement_id' => 'required|exists:type_abonnements,id'
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
         $abonnee = Abonnee::find($id) ;
         if($abonnee){
            try {
                $abonnee->update($validator->validated());
                return response()->json(
                    [
                        "message" => 'abonnee mis a jour avec success',
                        'data' => $abonnee,
                        'statusCode' => 200
                    ]
                );
            } catch (Exception $e) {
                    return response()->json([
                        'statusCode' => 500,
                        'message' => 'un probleme est survenu',
                        'error' => $e->getMessage()
                    ]);
            }
         }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous avons pas trouver abonnee avec cette id'
            ]);
         }
    }

  /**
 * @OA\Post(
 *     path="/api/abonnee/create",
 *     tags={"Abonnee"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"statut", "slug", "utilisateur_id" ,"typeabonnement_id"},
 *             @OA\Property(property="statut", type="string", example="En cours"),
 *             @OA\Property(property="slug", type="string", example="slug"),
 *             @OA\Property(property="utilisateur_id", type="string", example="2")
 *         )
 *     ),
 *     @OA\Response(response="201", description="Abonnee created"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
    public function registerAbonnee(Request $request)
    {
        $validator =   Validator::make($request->all() ,[
            'statut' => 'required|string',
            'slug' => 'required|string',
            'utilisateur_id' => 'required|exists:utilisateurs,id' ,
            'typeabonnement_id' => 'required|exists:type_abonnements,id'
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ]);

        }
        try {
            //code...
            $abonnee =  Abonnee::create($validator->validated());
            return response()->json(
                [
                    "message" => 'abonnee ajouter avec success',
                    'data' => $abonnee,
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
     *     path="/api/v1/abonnee/show/{id}",
     *     tags={"Abonnee"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de abonnee",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showAbonnee($id)
    {

        $abonnee  = Abonnee::find($id) ;
        if($abonnee){

            return response()->json(
                [
                    "message" => 'abonnee recuperer avec success',
                    'data' => $abonnee,
                    'statusCode' => 200
                ]
            );
        }else{
            return response()->json(
                [
                    "message" => 'nous n \'avons pas trouver abonnee avec cette identifiant',
                    'statusCode' => 204
                ]
            );
        }
       
    }
/**
 * @OA\Delete(
 *     path="/api/v1/abonnee/{id}",
 *     tags={"Abonnee"},
 *     summary="Delete a user",
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
    public function deleteAbonnee($id){
        $abonnee = Abonnee::find($id) ;
        if($abonnee){
            $abonnee->deleted_at = Carbon::now() ;
            return response()->json([
                'message'=>"abonne suprimer avec succcess" ,
                "statusCode"=>203
            ]) ;
        }
        return response()->json([
            'message'=>"nous n'avons pas trouver de abonee avec cette id" ,
            "statusCode"=>404
        ]) ;
    }
    
}
