<?php

namespace App\Http\Controllers\Contrat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContratRequest;
use App\Models\Contrat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ContratController extends Controller
{

    /**
 * @OA\Get(
 *     path="/api/v1/contrat",
 *     tags={"Contrat"},
 *     summary="Liste des contrats",
 *     @OA\Response(
 *         response=200,
 *         description="Liste des abonnees récupérée avec succès"
 *     )
 * )
 */
    public function getAllContrat()
    {
        $contrat = Contrat::with('locataire')->get() ;
        return response()->json(
            [
                "message" => 'contrats recuperer avec success',
                'data' => $contrat,
                'statusCode' => 200
            ]
        );
    }
    /**
     * @OA\Post(
     *     path="/api/v1/contrat/create",
     *     tags={"Contrat"},
     *     summary="Create a new contrat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"duree", "slug", "utilisateur_id" ,"locataire_id"},
     *             @OA\Property(property="duree", type="string"),
     *             @OA\Property(property="charge", type="string"),
     *             @OA\Property(property="description_bail", type="string"),
     *             @OA\Property(property="indice_reference", type="string"),
     *             @OA\Property(property="close_revision_loyer", type="string"),
     *             @OA\Property(property="montantLoyer", type="string"),
     *             @OA\Property(property="closeparticuliere", type="string"),
     *             @OA\Property(property="aut_paiement", type="string"),
     *             @OA\Property(property="aut_avis_echeance", type="string"),
     *             @OA\Property(property="aut_quittance", type="string"),
     *             @OA\Property(property="type_echange_id", type="string"),
     *             @OA\Property(property="type_contrat_id", type="string"),
     *             @OA\Property(property="utilisateur_id", type="string", example="2"),
     *             @OA\Property(property="locataire_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Contrat created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function registerContrat(Request $request)
    {
        // $validator =   Validator::make($request->all(), [
        //     'duree' => "required|",
        //     'montantLoyer' => 'required|string',
        //     'close_revision_loyer' => 'required|string',
        //     'indice_reference' => 'required|string',
        //     'description_bail' => 'required|string',
        //     'closeparticuliere' => 'required|string',
        //     'garantsolidaire' => 'required|string',
        //     'aut_paiement' => 'required|string',
        //     'aut_avis_echeance' => 'required|string',
        //     'aut_quittance' => 'required|string',
        //     "charge" => "required|",
        //     "type_echange_id" => "required|exists:type_echanges ,id",
        //     "type_paiement_id" => "required|exists:type_paiements ,id",
        //     "type_contrat_id" => "required|exists:type_contrats ,id",
        //     "utilisateur_id" => "required|exists:utilisateurs ,id",
        //     "locataire_id" => "required|exists:utilisateurs ,id",
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'statusCode' => 422,
        //         'message' => 'probleme de validation de donnee',
        //         'error' => $validator->errors()
        //     ],422);
        // }
        $validator=   $this->validateContrat($request);
        if($validator !== null){
         return response()->json([
             'statusCode' => 422,
             'message' => 'probleme de validation de donner',
             'error' => $validator
         ],422) ;
        }
        try {
            $dataContrat = $request->all() ;
            $dataContrat['slug'] = $request->charge ;
            $dataContrat['statut'] = "actif";
            $contrat =  Contrat::create($dataContrat);
            if ($contrat) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => "contrat creer avec success",
                    'data' => $contrat
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "contrat  non   creer",
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ],500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/contrat/show/{id}",
     *     tags={"Contrat"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de Contrat",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showContrat($id)
    {
        $contrat = Contrat::find($id);
        if ($contrat) {
            return response()->json([
                'statusCode' => 200,
                'message' => "contrat recuperer avec success",
                'data' => $contrat
            ]);
        }
        return response()->json([
            'statusCode' => 404,
            'message' => 'nous n\'avons pas trouver de contrat avec cette id',
        ] ,404);
    }

    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/contrat/edit/{id}",
     *     tags={"Contrat"},
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
     *             required={"duree", "utilisateur_id" ,"locataire_id"},
     *             @OA\Property(property="duree", type="string"),
     *             @OA\Property(property="charge", type="string"),
     *             @OA\Property(property="description_bail", type="string"),
     *             @OA\Property(property="indice_reference", type="string"),
     *             @OA\Property(property="close_revision_loyer", type="string"),
     *             @OA\Property(property="montantLoyer", type="string"),
     *             @OA\Property(property="closeparticuliere", type="string"),
     *             @OA\Property(property="aut_paiement", type="string"),
     *             @OA\Property(property="aut_avis_echeance", type="string"),
     *             @OA\Property(property="aut_quittance", type="string"),
     *             @OA\Property(property="type_echange_id", type="string"),
     *             @OA\Property(property="type_contrat_id", type="string"),
     *             @OA\Property(property="utilisateur_id", type="string", example="2"),
     *             @OA\Property(property="locataire_id", type="string", example="2")
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updateContrat(Request $request, $id)
    {
        $contrat = Contrat::find($id);
        if ($contrat) {
            try{
                $this->authorize('update', $contrat) ;
                  }catch(Exception $e){
                      return response()->json([
                          'statusCode' => 403,
                          'message' => ' probleme d\'authorisation',
                          'error' => $e->getMessage()
                      ], 403);
                  }
            // $validator =   Validator::make($request->all(), [
            //     'duree' => "required|",
            //     'montantLoyer' => 'required|string',
            //     'close_revision_loyer' => 'required|string',
            //     'indice_reference' => 'required|string',
            //     'description_bail' => 'required|string',
            //     'closeparticuliere' => 'required|string',
            //     'garantsolidaire' => 'required|string',
            //     'aut_paiement' => 'required|string',
            //     'aut_avis_echeance' => 'required|string',
            //     'aut_quittance' => 'required|string',
            //     "charge" => "required|",
            //     "type_echange_id" => "required|exists:type_echanges ,id",
            //     "type_paiement_id" => "required|exists:type_paiements ,id",
            //     "type_contrat_id" => "required|exists:type_contrats ,id",
            //     "utilisateur_id" => "required|exists:utilisateurs ,id",
            //     "locataire_id" => "required|exists:utilisateurs ,id",
            // ]);
            // if ($validator->fails()) {
            //     return response()->json([
            //         'statusCode' => 422,
            //         'message' => 'probleme de validation de donnee',
            //         'error' => $validator->errors()
            //     ]);
            // }

            $validator=   $this->validateContrat($request);
            if($validator !== null){
             return response()->json([
                 'statusCode' => 422,
                 'message' => 'probleme de validation de donner',
                 'error' => $validator
             ],422) ;
            }

            try {
                $contrat->update($request->all());
                return response()->json([
                    'statusCode' => 200,
                    'message' => "contrat mis a jour  avec success",
                    'data' => $contrat
                ]);
            } catch (Exception $e) {
                //throw $th;
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu ',
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                "message" => "nous n'avons pas trouver de contrat avec cette id",
                "statusCode" => 404
            ]);
        }

        //
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/contrat/delete/{id}",
     *     tags={"Contrat"},
     *     summary="Delete a contrat",
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
    public function deleleContrat(string $id)
    {
        $contrat = Contrat::find($id);
        if ($contrat) {
            try{
                $this->authorize('delete', $contrat) ;
                  }catch(Exception $e){
                      return response()->json([
                          'statusCode' => 403,
                          'message' => ' probleme d\'authorisation',
                          'error' => $e->getMessage()
                      ], 403);
                  }
            $contrat->deleted_at = Carbon::now();
            return response()->json([
                'message' => "contrat suprimer avec succcess",
                "statusCode" => 203
            ]);
        }
        return response()->json([
            'message' => "nous n'avons pas trouver de contrat avec cette id",
            "statusCode" => 404
        ]);
    }

    private function  validateContrat($request){
        
        $validator =   Validator::make($request->all(), [
            'duree' => "required|",
            'montantLoyer' => 'required|string',
            'close_revision_loyer' => 'required|string',
            'indice_reference' => 'required|string',
            'description_bail' => 'required|string',
            'closeparticuliere' => 'required|string',
            'garantsolidaire' => 'required|string',
            'aut_paiement' => 'required|string',
            'aut_avis_echeance' => 'required|string',
            'aut_quittance' => 'required|string',
            "charge" => "required|",
            "type_echange_id" => "required|exists:type_echanges ,id",
            "type_paiement_id" => "required|exists:type_paiements ,id",
            "type_contrat_id" => "required|exists:type_contrats ,id",
            "utilisateur_id" => "required|exists:utilisateurs ,id",
            "locataire_id" => "required|exists:utilisateurs ,id",
        ]);

        if($validator->fails()){
            return $validator->errors()  ;

        }else{

            return null ;
        }

    }
}
