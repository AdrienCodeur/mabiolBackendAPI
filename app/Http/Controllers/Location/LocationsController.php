<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Http\Request;

class LocationsController extends Controller
{
   /**
 * @OA\Get(
 *     path="/api/v1/location",
 *     tags={"Locations"},
 *     summary="Liste des Locations",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des utilisateurs récupérée avec succès"
 *     )
 * )
 */
    public function getALLlocations()
    {
        $location =  Location::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "type bien recuperer avec success",
            'data' => $location
        ]);
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/location/edit/{id}",
     *     tags={"Locations"},
     *     summary="Update a Location",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Location",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contrat_id","slug", "locataire_id" ,"proprietaire_id"},
     *             @OA\Property(property="proprietaire_id", type="string", example="En cours"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="locataire_id", type="string"),
     *             @OA\Property(property="contrat_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updateLocation($id,Request $request)
    {
        $location  = Location::find($id)  ;
        if($location){
            $validator =   Validator::make($request->all() ,[
                'locataire_id'=>'required|exists:utilisateurs,id' ,
                'proprietaire'=>'required|exists:utilisateurs ,id' ,
                'contrat_id'=>'required|exists:contrats ,id' ,
                'slug'=>'required|string'
            ])  ;
            if($validator->fails()){
                return response()->json([
                    'statusCode' => 422,
                    'message' => 'probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
            try {
               $result =   $location->update($validator->validated());
               if($result){
                return   response()->json( [
                    'statusCode'=>200,
                        'message'=>"location mis a jour  avec success", 
                        'data'=>$result
                ]) ;
               }else{
                return   response()->json( [
                    'statusCode'=>203,
                        'message'=>" la location n'a pas ete mis a jour", 
                ]) ;
               }
            } catch (Exception $e) {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu revoyer  votre demande ',
                    'error' => $e->getMessage()
                ]);
            }

        }
        return response()->json([
            'message'=>"nous n'avons pas trouver de location avec cette id" ,
            "statusCode"=>404
        ]) ;
    }
   /**
     * @OA\Post(
     *     path="/api/v1/location/create",
     *     tags={"Locations"},
     *     summary="Create a new location",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contrat_id","slug", "locataire_id" ,"proprietaire_id"},
     *             @OA\Property(property="proprietaire_id", type="string", example="En cours"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="locataire_id", type="string"),
     *             @OA\Property(property="contrat_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Location created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function registerLocation(Request $request)
    {

        $validator =   Validator::make($request->all() ,[
            'locataire_id'=>'required|exists:utilisateurs,id' ,
            'proprietaire'=>'required|exists:utilisateurs ,id' ,
            'contrat_id'=>'required|exists:contrats ,id' ,
            'slug'=>'required|string'
        ])  ;
        if($validator->fails()){
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
            try {
        $location = Location::create($validator->validated());
                if($location){
                        return   response()->json( [
                            'statusCode'=>200,
                                'message'=>"type bien  recuperer avec success", 
                                'data'=>$location
                        ]) ;
                }else{
                    return   response()->json( [
                        'statusCode'=>203,
                            'message'=>"location non  avec creer verifier vos donnees", 
                            // 'data'=>$location
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
 *     path="/api/v1/location/delete/{id}",
 *     tags={"Locations"},
 *     summary="Delete a Location",
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
public function deleleLocation(string $id)
{
    $location = Location::find($id) ;
    if($location){
        $location->deleted_at = Carbon::now() ;
        return response()->json([
            'message'=>"location suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de abonee avec cette id" ,
        "statusCode"=>404
    ]) ;
}
    /**
     * @OA\Get(
     *     path="/api/v1/location/show/{id}",
     *     tags={"Locations"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Location",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showLocation($id)
    {
        $location = Location::find($id) ;
        if($location){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"type bien  recuperer avec success", 
                    'data'=>$location
            ]) ;
        }
        return   response()->json( [
            'statusCode'=>404,
                'message'=>"nous n'avons pas trouver de location avec cette id", 
        ]) ;
      
    }
}
