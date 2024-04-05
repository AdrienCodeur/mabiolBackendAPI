<?php

namespace App\Http\Controllers\Ville;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class VilleController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/ville",
 *     tags={"Ville"},
 *     summary="Liste des  villes",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des villes  récupérée avec succès"
 *     )
 * )
 */
    public function getAllVille()
    {
         $ville = Ville::all() ;
         return response()->json([
            "message" =>"villes recuperer avec success" ,
            'data'=>$ville
         ]);
    }

    /** 
    * @OA\Post(
        *     path="/api/v1/ville/create",
        *     tags={"Ville"},
        *     summary="Create a new  Ville",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"region_id" ,"pay_id" ,"nom"} ,
        *             @OA\Property(property="region_id", type="string") ,
        *             @OA\Property(property="pay_id", type="string") ,
        *             @OA\Property(property="nom", type="string")
        *         )
        *     ),
        *     @OA\Response(response="201", description="Ville created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerVille(Request $request)
    {
        $validator  =   Validator::make($request->all() ,['nom' => 'required|string',
        'pay_id' => 'required|',
        'region_id' => 'required']) ;
        if($validator->fails()){
            return response()->json([
                'message'=>"erreur de validation"  ,
                "error"=>$validator->errors()
            ]) ;
        }
        try {
           
            $ville =  Ville::create($validator->validated());
            if ($ville) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => "ville creer avec success",
                    'data' => $ville
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "ville  non   creer",
                    // 'data'=>$userUtilisateur   
                ]);
            }
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ]);
        }
    }

     /**
     * @OA\Get(
     *     path="/api/v1/ville/show/{id}",
     *     tags={"Ville"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Ville",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showVille($id)
    {
        $ville = Ville::find($id) ;
        if($ville){
            return response()->json([
                'statusCode' => 200,
                'message' => "ville recuperer avec success",
                'data' => $ville
            ]);

        }
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\'avons pas trouver de ville avec cette id ',
            ]);
        //
    }

/**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/ville/edit/{id}",
     *     tags={"Ville"},
     *     summary="Update a ville",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the ville",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","pay_id", "region_id"},
     *             @OA\Property(property="nom", type="string", example="En cours"),
     *             @OA\Property(property="pay_id", type="string"),
     *             @OA\Property(property="region_id", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */

    public function updateVille(Request $request, $id)
    {
        $ville = Ville::find($id) ;
        if($ville){
            $validator  =   Validator::make($request->all() ,[ 
                'nom' => 'required|string',
           'pay_id' => 'required|exists:pays ,id',
           'region_id' => 'required|exists:regions ,id']) ;
           if($validator->fails()){
               return response()->json([
                   'message'=>"erreur de validation"  ,
                   "error"=>$validator->errors()
               ]) ;
           }
            try {
                $ville->update($validator->validated());
                return response()->json([
                    'statusCode' => 200,
                    'message' => "ville mis a jour  avec success",
                    'data' => $ville
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu ',
                    'error' => $e->getMessage()
                ]);
            }
        }
        return response()->json([
            "message"=>"nous n'avons pas trouver de ville avec cette id" ,
            "statutCode"=>404
        ]) ;
    }

   /**
 * @OA\Delete(
 *     path="/api/v1/ville/delete/{id}",
 *     tags={"Ville"},
 *     summary="Delete a Ville",
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
public function deleleVille(string $id)
{
    $Ville = Ville::find($id) ;
    if($Ville){
        $Ville->deleted_at = Carbon::now() ;
        return response()->json([
            'message'=>"Ville suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de Ville avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}

