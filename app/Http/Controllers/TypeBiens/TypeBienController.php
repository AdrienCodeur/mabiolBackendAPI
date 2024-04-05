<?php

namespace App\Http\Controllers\TypeBiens;

use App\Http\Controllers\Controller;
use App\Models\Typebien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeBienController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/typeBien",
 *     tags={"TypeBien"},
 *     summary="Liste des Types de  Bien",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des  types biens  récupérée avec succès"
 *     )
 * )
 */
    public function getAllTypeBien()
    {
        $typebien =  Typebien::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "type bien recuperer avec success",
            'data' => $typebien
        ]);
    }

    /**
 * Update the specified resource in storage.
 */ /**
 * @OA\Put(
 *     path="/api/v1/typeBien/edit/{id}",
 *     tags={"TypeBien"},
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
 *             required={"libelle"},
 *             @OA\Property(property="libelle", type="string", example="En cours"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="User updated"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
    public function updateTypeBien($id, Request $request)
    {
       
        $typebien = Typebien::find($id)  ;
        if($typebien){
            $validator =   Validator::make($request->all() ,[
                'libelle' => 'required|string',
             
            ])  ;
            if($validator->fails()){
                return response()->json([
                    'statusCode' => 203,
                    'message' => 'probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
            $typebien->update($validator->validated());
            return response()->json([
                'statusCode' => 200,
                'message' => 'type bien mis a jour avec success',
                'error' => $typebien
            ]);
        
        }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\'avons pas trouver de de type de bien avec cette id',
            ]);
        }
      
    }
  /** 
    * @OA\Post(
        *     path="/api/v1/typeBien/create",
        *     tags={"TypeBien"},
        *     summary="Create a new TypeBien",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"libelle"},
        *             @OA\Property(property="libelle", type="string")
        *         )
        *     ),
        *     @OA\Response(response="201", description="TypeAb created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerTypeBien(Request $request)
    {
        $validator =   Validator::make($request->all() ,[
            'libelle' => 'required|string',
         
        ])  ;
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        $typebien = Typebien::create($validator->validated());
        return response()->json([
            'statusCode' => 203,
            'message' => 'type bien creer avec success',
            'error' => $typebien
        ]);
    }
        /**
     * @OA\Get(
     *     path="/api/v1/typeBien/show/{id}",
     *     tags={"TypeBien"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de TypeBien",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showTypeBien($id)
    {
        $typebien = Typebien::find($id) ;
        if($typebien){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"type bien  recuperer avec success", 
                    'data'=>$typebien
            ]) ;
        }
        return   response()->json( [
            'statusCode'=>404,
                'message'=>"nous avons pas trouver de type bien  avec cette id "
        ]) ;
    }
 /**
 * @OA\Delete(
 *     path="/api/v1/typeBien/delete/{id}",
 *     tags={"TypeBien"},
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
    $typeAb = Typebien::find($id) ;
    if($typeAb){
        $typeAb->deleted_at = Carbon::now() ;
        return response()->json([
            'message'=>"typeBien suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de typeBien avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
