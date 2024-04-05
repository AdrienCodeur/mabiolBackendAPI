<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceRequest;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception ;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
class FinancesController extends Controller
{

    
/**
 *  @OA\Info(title="My First API", version="0.1")
 * @OA\Get(
 *     path="/api/v1/finance",
 *     tags={"Finances"},
 *     summary="Liste des finances",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des utilisateurs récupérée avec succès"
 *     )
 * )
 */
    public function getAllFinance()
    {
        $finance =  Finance::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "type bien recuperer avec success",
            'data' => $finance
        ]);
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/finance/edit/{id}",
     *     tags={"Finances"},
     *     summary="Update a Finance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Finance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"montant", "slug", "statut" ,"proprietaire_id"},
     *             @OA\Property(property="statut", type="string", example="En cours"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="type_Finance_id", type="string"),
     *             @OA\Property(property="frequence", type="string"),
     *             @OA\Property(property="commentaire", type="string"),
     *             @OA\Property(property="periode", type="string"),
     *             @OA\Property(property="montant", type="string"),
     *             @OA\Property(property="datepaiement", type="string"),
     *             @OA\Property(property="autre_typepaiement", type="string"),
     *             @OA\Property(property="typePaiement_id", type="string"),
     *             @OA\Property(property="bien_id", type="string", example="2"),
     *             @OA\Property(property="proprietaire_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updateFinance(string $id, Request $request)
    {

        $finance = Finance::find($id) ; 
        if($finance){
            $validator =   Validator::make($request->all(), [
                'proprietaire_id'=>'required' ,
                'bien_id'=>'required' ,
                'typePaiement_id'=>'required' ,
                'autre_typepaiement'=>'required' ,
                'datepaiement'=>'required',
                'montant'=>'required',
                'statut'=>'required' ,
                'periode'=>'required' ,
                'commentaire'=>'required' ,
                'frequence'=>'required' ,
                'typeFinance_id'=>'required' ,
                'slug'=>'required' ,
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 422,
                    'message' => 'probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
                try {
                    $validated = $request->validate();
                   $result =   $finance->update($validated);
                   if($result){
                    return   response()->json( [
                        'statusCode'=>200,
                            'message'=>"finance mis a jour  avec success", 
                            'data'=>$result
                    ]) ;
                   }else{
                    return   response()->json( [
                        'statusCode'=>203,
                            'message'=>" la finance n'a pas ete mis a jour", 
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
            'statusCode' => 404,
            'message' => "finance not found by id" ,
        ]);
        
    }
   /**
     * @OA\Post(
     *     path="/api/v1/finance/create",
     *     tags={"Finances"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"statut","slug", "bien_id" ,"proprietaire_id"},
     *             @OA\Property(property="statut", type="string", example="En cours"),
     *             @OA\Property(property="slug", type="string"),
     *             @OA\Property(property="type_Finance_id", type="string"),
     *             @OA\Property(property="frequence", type="string"),
     *             @OA\Property(property="commentaire", type="string"),
     *             @OA\Property(property="periode", type="string"),
     *             @OA\Property(property="montant", type="string"),
     *             @OA\Property(property="datepaiement", type="string"),
     *             @OA\Property(property="autre_typepaiement", type="string"),
     *             @OA\Property(property="typePaiement_id", type="string"),
     *             @OA\Property(property="bien_id", type="string", example="2"),
     *             @OA\Property(property="proprietaire_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Finance created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function registerFinance(Request $request)
    {

        $validator =   Validator::make($request->all(), [
            'proprietaire_id'=>'required' ,
            'bien_id'=>'required' ,
            'typePaiment_id'=>'required' ,
            'autre_typepaiment'=>'required' ,
            'datepaiment'=>'required',
            'montant'=>'required',
            'statut'=>'required' ,
            'periode'=>'required' ,
            'commentaire'=>'required' ,
            'frequence'=>'required' ,
            'typeFinance_id'=>'required' ,
            'slug'=>'required' ,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
            try {
        $validated = $request->validate();
        $finance = Finance::create($validated);
                if($finance){
                        return   response()->json( [
                            'statusCode'=>200,
                                'message'=>"finance creer avec success", 
                                'data'=>$finance
                        ]) ;
                }else{
                    return   response()->json( [
                        'statusCode'=>203,
                            'message'=>"finance non   creer verifier vos donnees", 
                            // 'data'=>$finance
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
     *     path="/api/v1/finance/show/{id}",
     *     tags={"Finances"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Finance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showFinance(string $id)
    {
        $finance = Finance::find($id) ;
        if($finance){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"type bien  recuperer avec success", 
                    'data'=>$finance
            ])   ;
        }
        return   response()->json( [
            'statusCode'=>404,
                'message'=>"finance not found  ", 
        ])   ;
        
}
  /**
 * @OA\Delete(
 *     path="/api/v1/finance/delete/{id}",
 *     tags={"Finances"},
 *     summary="Delete a Finance",
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
public function deleleFinance(string $id)
{
    $finance = Finance::find($id) ;
    if($finance){
        $finance->deleted_at = Carbon::now() ;
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
