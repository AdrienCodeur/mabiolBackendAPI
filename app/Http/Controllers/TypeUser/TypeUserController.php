<?php

namespace App\Http\Controllers\TypeUser;

use App\Http\Controllers\Controller;
use App\Models\TypeUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception ;
use Illuminate\Support\Facades\Validator;

class TypeUserController extends Controller
{
     /**
 * @OA\Get(
 *     path="/api/v1/typeUser",
 *     tags={"TypeUser"},
 *     summary="Liste des Types de  Bien",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des  types biens  récupérée avec succès"
 *     )
 * )
 */
    public function getAllTypeUser()
    {
        $typeUser =  TypeUser::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "type user recuperer avec success",
            'data' => $typeUser
        ]);
    }


    
    /**
 * Update the specified resource in storage.
 */ /**
 * @OA\Put(
 *     path="/api/v1/typeUser/edit/{id}",
 *     tags={"TypeUser"},
 *     summary="Update a TypeUser",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the TypeUser",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"libelle"},
 *             @OA\Property(property="libelle", type="string", example="Admin"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="User updated"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
    public function updateTypeUser($id, Request $request)
    {
        $typeUser = TypeUser::find($id) ;
        if($typeUser){
            $validator  =   Validator::make($request->all() ,[ 'libelle'=>"required|string"]) ;
            if($validator->fails()){
                return response()->json([
                    'message'=>"erreur de validation",
                    "error"=>$validator->errors()
                ] ,422) ;
            }
            $typeUser->update($validator->validated());
            return response()->json([
                'statusCode' => 200,
                'message' => "type user  mis a jour avec success",
                'data' => $typeUser
            ] ,200);
        }
        return response()->json([
            'statusCode' => 404,
            'message' =>" nous n'avons pas trouver de type user avec cette id",
            'data' => $typeUser
        ] ,404);
        
    }
      /** 
    * @OA\Post(
        *     path="/api/v1/typeUser/create",
        *     tags={"TypeUser"},
        *     summary="Create a new TypeUser",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"libelle"},
        *             @OA\Property(property="libelle", type="string")
        *         )
        *     ),
        *     @OA\Response(response="201", description="TypeUser created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerTypeUser(Request $request)
    {
        $validator  =   Validator::make($request->all() ,[ 'libelle'=>"required|string"]) ;
        if($validator->fails()){
            return response()->json([
                'message'=>"erreur de validation"  ,
                "error"=>$validator->errors()
            ] ,422) ;
        }

        $typeUser =   new TypeUser()   ;
        $typeUser->libelle = $request->libelle ; 
        $typeUser->deleted_at = new Carbon() ;
        $typeUser->save() ;
        return response()->json(['statusCode' => 200,
        'message' => "type utilisateur creer avec success",
        'data' => $typeUser
    ] ,200);
    }
        /**
     * @OA\Get(
     *     path="/api/v1/typeUser/show/{id}",
     *     tags={"TypeUser"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de TypeUser",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showTypeUser($id) 
    {
        $typeuser = TypeUser::find($id) ;
        if($typeuser){
            return response()->json([
                'statusCode' => 200,
                'message' => "type utilisateur  recuperer avec success",
                'data' => $typeuser
            ],200);
        }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous  n\'avons pas trouver de type user avec cette id  ',
            ] ,404);
        }

    }


    
 /**
 * @OA\Delete(
 *     path="/api/v1/typeUser/delete/{id}",
 *     tags={"TypeUser"},
 *     summary="Delete a TypeUser",
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
public function deleleTypeUser(string $id)
{
    $typeUser = TypeUser::find($id) ;
    if($typeUser){
        $typeUser->deleted_at = Carbon::now() ;
        $typeUser->save() ;
        return response()->json([
            'message'=>"typeUser suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de typeUser avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
