<?php

namespace App\Http\Controllers\Pays;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class PaysController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/v1/pays",
 *     tags={"Pays"},
 *     summary="Liste des pays",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des utilisateurs récupérée avec succès"
 *     )
 * )
 */
    public function getAllPays()
    {
        $pay =  Pays::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "pays recuperer avec success",
            'data' => $pay
        ]);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/pays/edit/{id}",
     *     tags={"Pays"},
     *     summary="Update a Pays",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Pays",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="En cours"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updatePays(Request $request,$id)
    {
        //    if($validated){
        //     return response()->json($validated, 422);
        // }
        $validator  =Validator::make( $request->all(),[
            'nom' => 'required|string' 
        ]); 
        if($validator->fails()){
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
            $pays = Pays::find($id) ;
            $pays->update($validator->validated());
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"pays modifier avec success", 
                    'data'=>$pays
            ]) ;
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ]);
        }
    }

/** 
    * @OA\Post(
        *     path="/api/v1/pays/create",
        *     tags={"Pays"},
        *     summary="Create a new pays",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"nom"},
        *             @OA\Property(property="nom", type="string", example="En cours"),
        *         )
        *     ),
        *     @OA\Response(response="201", description="Pays created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerPays(Request $request)
    {
        $validator  =Validator::make( $request->all(),[
            'nom' => 'required|string|unique:pays ,nom' 
        ]); 
        if($validator->fails()){
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
            $validated = $request->validate([
                'nom' => 'required|string'
            ]);
            $pay = Pays::create($validated);

            if ($pay) {
                return   response()->json( [
                    'statusCode'=>200,
                        'message'=>"pays  creer avec success", 
                        'data'=>$pay
                ]) ;
            } else {
                return   response()->json( [
                    'statusCode'=>203,
                        'message'=>"pays non creer verifier vos donnees", 
                        // 'data'=>$pays
                ]) ;

            }
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
     *     path="/api/v1/pays/show/{id}",
     *     tags={"Pays"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de pays",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showPays($id)
    {
    try {

        $pays = Pays::find($id) ;
        if($pays){
        return   response()->json( [
            'statusCode'=>200,
                'message'=>"pays   recuperer en particulier  avec success", 
                'data'=>$pays
        ]) ;
    }else{
        return   response()->json( [
            'statusCode'=>203,
                'message'=>"nous n'avons pas trouver de payer avec l'identifiant unique passer", 
        ]) ;
    }
    } catch (Exception $e) {
        return response()->json([
            'statusCode' => 500,
            'message' => 'un probleme est survenu ',
            'error' => $e->getMessage()
        ]);
    }

}

 /**
 * @OA\Delete(
 *     path="/api/v1/pays/delete/{id}",
 *     tags={"Pays"},
 *     summary="Delete a Pays",
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
public function delelePays(string $id)
{
    $pays = Pays::find($id) ;
    if($pays){
        $pays->deleted_at = Carbon::now() ;
        return response()->json([
            'message'=>"pays suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de abonee avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
