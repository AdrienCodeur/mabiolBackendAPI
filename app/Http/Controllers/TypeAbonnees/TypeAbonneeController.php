<?php

namespace App\Http\Controllers\TypeAbonnees;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeAbonnementRequest;
use App\Models\TypeAbonnement;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Http\Request;
 // getAllTypeAb  
class TypeAbonneeController extends Controller
{
            /**
 * @OA\Get(
 *     path="/api/v1/typeAb",
 *     tags={"TypeAb"},
 *     summary="Liste des typeabonnement",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des utilisateurs récupérée avec succès"
 *     )
 * )
 */
    public function getAllTyperAb()
    {
        $typeAb =  TypeAbonnement::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "type abonnement recuperer avec success",
            'data' => $typeAb
        ]);
    }
/**
 * Update the specified resource in storage.
 */ /**
 * @OA\Put(
 *     path="/api/v1/typeAb/edit/{id}",
 *     tags={"TypeAb"},
 *     summary="Update a TypeAb",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the TypeAb",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="En cours"),
 *             @OA\Property(property="montant", type="string", example="En cours"),
 *             @OA\Property(property="description", type="string", example="En cours"),
 *             @OA\Property(property="duree", type="string", example="En cours"),
 *             @OA\Property(property="slug", type="string", example="En cours"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="User updated"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
    public function updateTyperAb(string $id,Request $request)
    {
        $typeAb = TypeAbonnement::find($id) ;
        if($typeAb){
            $validator =   Validator::make($request->all() ,[
                'nom' => 'required|string',
                'montant' => 'required|string',
                'description' => 'required|string',
                'duree' => 'required' ,
                'slug' => 'required'
            ])  ; 
            if($validator->fails()){
                return response()->json([
                    'statusCode' => 203,
                    'message' => 'probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
            
            try {
                $validated = $request->validate() ;
                $typeAb->update($validated);
                } catch (Exception $e) {
                    return response()->json([
                        'statusCode' => 500,
                        'message' => 'un probleme est survenu ',
                        'error' => $e->getMessage()
                    ]);
                }
        }
        return response()->json([
            'statusCode' => 404,
            'message' => 'typeabonnement not found',
        ]);

    }
    /** 
    * @OA\Post(
        *     path="/api/v1/typeAb/create",
        *     tags={"TypeAb"},
        *     summary="Create a new TypeAb",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"nom"},
        *             @OA\Property(property="nom", type="string"),
        *             @OA\Property(property="montant", type="string"),
        *             @OA\Property(property="description", type="string"),
        *             @OA\Property(property="duree", type="string"),
        *             @OA\Property(property="slug", type="string"),
        *         )
        *     ),
        *     @OA\Response(response="201", description="TypeAb created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerTypeAb(Request $request)
    {
        $validator =   Validator::make($request->all() ,[
            'nom' => 'required|string',
            'montant' => 'required|string',
            'description' => 'required|string',
            'duree' => 'required' ,
            'slug' => 'required'
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
        $typeAb = TypeAbonnement::create($validator->validated());
        return response()->json([
            'statusCode' => 202,
            'message' => 'type abonnement creer avec success',
            'data' => $typeAb
        ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est surven',
                'error' => $e->getMessage()
            ]);
        }
    }
         /**
     * @OA\Get(
     *     path="/api/v1/typeAb/show/{id}",
     *     tags={"TypeAb"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de TypeAb",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */

    public function  showTypeAb(string $id)
    {
        $typeabonnement = TypeAbonnement::find($id) ;
        if($typeabonnement){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"type abonnement  recuperer avec success",
                    'data'=>$typeabonnement
            ]) ;
        }
        return   response()->json( [
            'statusCode'=>404,
                'message'=>"type abonnement  not found",
        ]) ;
    }

 /**
 * @OA\Delete(
 *     path="/api/v1/typeAb/delete/{id}",
 *     tags={"typeAb"},
 *     summary="Delete a typeAb",
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
public function deleletypeAb(string $id)
{
    $typeAb = TypeAbonnement::find($id) ;
    if($typeAb){
        $typeAb->deleted_at = Carbon::now() ;
        $typeAb->save() ;
        return response()->json([
            'message'=>"typeAb suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de typeAb avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
