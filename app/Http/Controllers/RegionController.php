<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
     /**
 * @OA\Get(
 *     path="/api/v1/region",
 *     tags={"Region"},
 *     summary="Liste des  Regions",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des Regions  récupérée avec succès"
 *     )
 * )
 */
    public function getAllRegion()
    {
         $region = Region::all() ;
         return response()->json([
            "message" =>"regions recuperer avec success" ,
            'data'=>$region
         ]);
    }

      /** 
    * @OA\Post(
        *     path="/api/v1/region/create",
        *     tags={"Region"},
        *     summary="Create a new  Region",
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"pay_id" ,"nom"} ,
        *             @OA\Property(property="nom", type="string") ,
        *             @OA\Property(property="pay_id", type="string"),
        *         )
        *     ),
        *     @OA\Response(response="201", description="Region created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function registerRegion(Request $request)
    {
        $validator  =   Validator::make($request->all() ,[
        'nom' => 'required|string',
        'pay_id' => 'required|exists:pays,id',
        ]) ;
        if($validator->fails()){
            return response()->json([
                'message'=>"erreur de validation",
                "error"=>$validator->errors()
            ]) ;
        }
        try {
           
            $region =  Region::create($validator->validated());
            if ($region) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => "region creer avec success",
                    'data' => $region
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "region  non   creer",
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
    


    // public function showRegion($id)
    // {
    //     $region = Region::find($id) ;
    //     if($region){
    //         return response()->json([
    //             'statusCode' => 200,
    //             'message' => "region recuperer avec success",
    //             'data' => $region
    //         ]);

    //     }
    //         return response()->json([
    //             'statusCode' => 404,
    //             'message' => 'nous n\'avons pas trouver de region avec cette id ',
    //         ]);
    //     //
    // }
     /**
     * @OA\Get(
     *     path="/api/v1/region/show/{id}",
     *     tags={"Region"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Region",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showRegion($id)
    {
        $region = Region::find($id) ;
        if($region){
            return response()->json([
                'statusCode' => 200,
                'message' => "region recuperer avec success",
                'data' => $region
            ]);

        }
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\'avons pas trouver de region avec cette id ',
            ],404);
        //
    }


/**
* Update the specified resource in storage.
*/ /**
* @OA\Put(
*     path="/api/v1/region/edit/{id}",
*     tags={"Region"},
*     summary="Update a Region",
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="ID of the Region",
*         @OA\Schema(type="integer")
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             required={"nom" ,"pay_id"},
*             @OA\Property(property="nom", type="string"),
*             @OA\Property(property="pay_id", type="string")
*         )
*     ),
*     @OA\Response(response="200", description="User updated"),
*     @OA\Response(response="404", description="User not found"),
*     @OA\Response(response="422", description="Validation error")
* ) 
 */
    public function updateRegion(Request $request, $id)
    {

        try {
        $region = Region::find($id) ;
            $this->authorize('update', $region);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 403,
                'message' => ' probleme d\'authorisation',
                'error' => $e->getMessage()
            ], 403);
        }
        if($region){
            $validator  =   Validator::make($request->all() ,[ 
                'nom' => 'required|string',
           'pay_id' => 'required|exists:pays,id',
           ]) ;
           if($validator->fails()){
               return response()->json([
                   'message'=>"erreur de validation"  ,
                   "error"=>$validator->errors()
               ]) ;
           }
            try {

                $region->update($validator->validated());
                return response()->json([
                    'statusCode' => 200,
                    'message' => "region mis a jour  avec success",
                    'data' => $region
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
            "message"=>"nous n'avons pas trouver de region avec cette id" ,
            "statutCode"=>404
        ]) ;
    }


}
