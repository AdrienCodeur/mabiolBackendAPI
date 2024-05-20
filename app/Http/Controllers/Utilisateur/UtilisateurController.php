<?php

namespace App\Http\Controllers\Utilisateur;

use App\Http\Controllers\Controller;
use App\Http\Requests\UtilisateurRequest;
use App\Models\TypeUser;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UtilisateurController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/v1/utilisateurs",
     *     tags={"Utilisateurs"},
     *     summary="Liste des  utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des   utilisateurs  récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        try {
            $proprietaire =  Utilisateur::with('typeUser')->whereHas('typeUser', function ($query) {
                $query->where('libelle', 'Proprietaire');
            })->get();
            return response()->json([
                'statusCode' => 200,
                'message' => "proprietaire recuperer  success",
                'data' => $proprietaire
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/utilisateurs/edit/{id}",
     *     tags={"Utilisateurs"},
     *     summary="Update a proprietaire",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the utilisateurs",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="nom", type="string" ,example="djeudje tenkeu"),
     *             @OA\Property(property="telephone", type="string"),
     *             @OA\Property(property="addresse", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="sexe", type="string" ,example="Masculin"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * ) 
     */
    public function  editUtilisateur(Request $request, $id)
    {

        // return $request ;
        $utilisateur =  Utilisateur::find($id);
        if ($utilisateur) {
            try{
                $this->authorize('update', $utilisateur) ;
                  }catch(Exception $e){
                      return response()->json([
                          'statusCode' => 403,
                          'message' => ' probleme d\'authorisation',
                          'error' => $e->getMessage()
                      ], 403);
                  }
            // $validator =   Validator::make($request->all(), [
            //     'email' => ['required', 'email ', Rule::unique('utilisateurs')->ignore($utilisateurId->id),],
            //     'password' => 'required|min:5',
            //     'nom' => 'required|string',
            //     'telephone' => 'required|string',
            //     'addresse' => 'required|string',
            //     'sexe' => 'required|string',
            //     // 'type_user_id' => 'required|exists:type_users,id'
            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'statusCode' => 203,
            //         'message' => ' probleme de validation de donnee',
            //         'error' => $validator->errors()
            //     ]);
            // }
            $validator =  $this->validateUtilisateur($request);
        if ($validator!==null) {
            // Si le validateur renvoie des erreurs, retourner une réponse avec les erreurs
            return response()->json([
                'statusCode' => 422,
                'message' => 'Problème de validation de données',
                'errors' => $validator
            ], 422);
        }
            try {
                $utilisateurUpdate =    $utilisateur->update($request->all());
                if ($utilisateurUpdate) {
                    return response()->json([
                        'statusCode' => 200,
                        'message' => "locataire mis a jour  success",
                        'data' => $utilisateur
                    ], 200);
                } else {
                    return response()->json([
                        'statusCode' => 204,
                        'message' => "utilisateurs na pas ete  mis a jour"
                    ], 204);
                }
            } catch (Exception $e) {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu ',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\'avons pas trouver utilisateur avec cette id',
            ], 404);
        }
    }
    /** 
     * @OA\Post(
     *     path="/api/v1/utilisateurs/create",
     *     tags={"Utilisateurs"},
     *     summary="Create a new  utilisateurs",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password" ,"nom","telephone","addresse"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *             @OA\Property(property="nom", type="string") ,
     *             @OA\Property(property="sexe", type="string") ,
     *             @OA\Property(property="telephone", type="string") ,
     *             @OA\Property(property="addresse", type="string") ,
     *         )
     *     ),
     *     @OA\Response(response="201", description="utilisateurs created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function createUtilisateur(Request $request)
    {
        // $validator =   Validator::make($request->all(), [
        //     'email' => 'required|string|email|unique:utilisateurs,email',
        //     'password' => 'required|min:5',
        //     'nom' => 'required|string',
        //     'telephone' => 'required|string',
        //     'addresse' => 'required|string',
        //     'sexe' => 'required|string',
        //     // 'type_user_id' => 'required|exists:type_users,id'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'statusCode' => 422,
        //         'message' => ' probleme de validation de donnee',
        //         'error' => $validator->errors()
        //     ], 422);
        // }

        $validator =  $this->validateUtilisateur($request);
        if ($validator!==null) {
            // Si le validateur renvoie des erreurs, retourner une réponse avec les erreurs
            return response()->json([
                'statusCode' => 422,
                'message' => 'Problème de validation de données',
                'errors' => $validator
            ], 422);
        }
        try {
            $typeUser = TypeUser::where("libelle", "Proprietaire")->first();
            $newUtilisateur =   new Utilisateur();
            $newUtilisateur->email = $request->email;
            $newUtilisateur->nom = $request->nom;
            $newUtilisateur->telephone = $request->telephone;
            $newUtilisateur->addresse = $request->addresse;
            $newUtilisateur->type_user = $typeUser->id;
            $newUtilisateur->login = $request->email;
            $newUtilisateur->sexe = $request->sexe;
            $newUtilisateur->slug = $request->nom;
            $newUtilisateur->statut = "actif";
            $newUtilisateur->password = Hash::make($request->password);
            $newUtilisateur->save();
            if ($newUtilisateur) {
                // $data =  $newUtilisateur->with('typeUser')->first();
                // return $data ;
                return response()->json([
                    'statusCode' => 200,
                    'message' => "utilisateur creer avec success",
                    'data' => $newUtilisateur
                ], 200);
            } else {
                return response()->json([
                    'statusCode' => 500,
                    'message' => "utilisateur n'a pas ete creer",
                    // 'data'=>$userUtilisateur   
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   /** 
     * @OA\Post(
     *     path="/api/v1/utilisateurs/create_and_login",
     *     tags={"Utilisateurs"},
     *     summary="Create a new  utilisateurs",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password" ,"nom","telephone","addresse"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *             @OA\Property(property="nom", type="string") ,
     *             @OA\Property(property="sexe", type="string") ,
     *             @OA\Property(property="telephone", type="string") ,
     *             @OA\Property(property="addresse", type="string") ,
     *         )
     *     ),
     *     @OA\Response(response="201", description="utilisateurs created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function createAndLoginUser(Request $request)
    {
        $validator =   Validator::make($request->all(), [
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'addresse' => 'required|string',
            'sexe' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ], 422);
        }
        try {
            $typeUser = TypeUser::where("libelle", "Proprietaire")->first();
            $newUtilisateur =   new Utilisateur();
            $newUtilisateur->email = $request->email;
            $newUtilisateur->nom = $request->nom;
            $newUtilisateur->telephone = $request->telephone;
            $newUtilisateur->addresse = $request->addresse;
            $newUtilisateur->type_user = $typeUser->id;
            $newUtilisateur->login = $request->email;
            $newUtilisateur->sexe = $request->sexe;
            $newUtilisateur->slug = $request->nom;
            $newUtilisateur->statut = "actif";
            $newUtilisateur->password = Hash::make($request->password);
            $newUtilisateur->save();


            if ($newUtilisateur) {
                // Récupérer le libellé du type d'utilisateur associé
                $typeUserLibelle = $typeUser->libelle;
                // Remplacer l'ID du type d'utilisateur par son libellé dans la réponse JSON
                $newUtilisateur->type_user = $typeUserLibelle;
                $token =    $newUtilisateur->createToken('utilisateurKey')->plainTextToken;
                if ($token) {
                    // Retourner la réponse avec le token
                    return response()->json([
                        'statusCode' => 200,
                        'message' => "Utilisateur créé avec succès et connecté",
                        'token' => $token,
                        "data" => $newUtilisateur,
                    ], 200);
                }

                return response()->json([
                    'statusCode' => 200,
                    'message' => "utilisateur creer avec success",
                    'data' => $newUtilisateur
                ], 200);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "utilisateur n'a pas ete creer",
                ], 203);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/utilisateurs/showById/{id}",
     *     tags={"Utilisateurs"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de utilisateurs",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showUtilisateurById($id)
    {
        $utilisateurId = Utilisateur::with('typeUser')->whereHas('typeUser', function ($query) {
            $query->where('libelle', 'Proprietaire');
        })->find($id);
        try {
            if ($utilisateurId) {
                return   response()->json([
                    'statusCode' => 203,
                    'message' => " proprietaire  recuperer en particulier  avec success",
                    'data' => $utilisateurId
                ], 203);
            } else {
                return   response()->json([
                    'statusCode' => 404,
                    'message' => "nous n'avons pas trouver de proprietaire  avec l'identifiant unique passer",
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ], 500);
        }
    }
        /**
     * @OA\Get(
     *     path="/api/v1/utilisateurs/showBySlug/{slug}",
     *     tags={"Utilisateurs"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description=" id de utilisateurs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showUtilisateurBySlug($slug)
    {
        $utilisateur = Utilisateur::with('typeUser')
        ->where('slug', $slug)
        ->first();
        try {
            if ($utilisateur) {
                return   response()->json([
                    'statusCode' => 200,
                    'message' => " utilisateur  recuperer en particulier  avec success",
                    'data' => $utilisateur
                ], 200);
            } else {
                return   response()->json([
                    'statusCode' => 405,
                    'message' => "nous n'avons pas trouver de proprietaire  avec l'identifiant unique passer",
                    "data" =>$utilisateur ,
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/utilisateurs/delete/{id}",
     *     tags={"Utilisateurs"},
     *     summary="Delete a Utilisateurs",
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
    public function deleteUtilisateur(string $id)
    {
        $utilisateurs = Utilisateur::find($id);
        if ($utilisateurs) {
            try{
                $this->authorize('delete', $utilisateurs) ;
                  }catch(Exception $e){
                      return response()->json([
                          'statusCode' => 403,
                          'message' => ' probleme d\'authorisation',
                          'error' => $e->getMessage()
                      ], 403);
                  }
            $utilisateurs->deleted_at = Carbon::now();
            $utilisateurs->save();
            return response()->json([
                'message' => "utilisateurs suprimer avec succcess",
                "statusCode" => 203
            ], 203);
        }
        return response()->json([
            'message' => "nous n'avons pas trouver de utilisateurs avec cette id",
            "statusCode" => 404
        ], 404);
    }





    /**
     * @OA\Get(
     *     path="/api/v1/utilisateurs/getLocataires/{proprietaire_id}",
     *     tags={"Utilisateurs"},
     *     summary="Liste tous les proprietaires d'un locataires en passant l'id  du locataires",
     *     @OA\Parameter(
     *         name="proprietaire_id",
     *         in="path",
     *         required=true,
     *         description=" id de utilisateurs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function getLocataires($proprietaire_id)
    {
        $id = $proprietaire_id;
        $utilisateur = Utilisateur::find($id);
        if ($utilisateur) {
            // pour  gerer les authorizations 
            try{
                $this->authorize('update', $utilisateur) ;
            }catch(Exception $e){
                return response()->json([
                    'statusCode' => 403,
                    'message' => ' probleme d\'authorisation',
                    'error' => $e->getMessage()
                ], 403);
            }
            $result = $utilisateur->locataires;
            return response()->json([
                "statusCode" => 200,
                "message" => "nous avons recuperer les locataire  du  proprietaires  avec l'Id passer",
                "data" => $result
            ]);
        } else {
            return response()->json([
                "statusCode" => 404,
                "message" => "nous n'avons pas trouver de locataire  pour le   proprietaire   avec identifiant"
            ], 404); {
                $utilisateur = Utilisateur::find($id);
                if ($utilisateur) {
                    $result = $utilisateur->locataires;
                    return response()->json([
                        "statusCode" => 200,
                        "message" => "nous avons recuperer les proprietaires/locataires  pour le proprietaire/locataire  avec l'Id passer",
                        "data" => $result
                    ]);
                } else {
                    return response()->json([
                        "statusCode" => 404,
                        "message" => "nous n'avons pas trouver de proprietaire/locataire avec cette identifiant"
                    ], 404);
                }
            }
        }
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/utilisateurs/editStatus/{id}",
     *     tags={"Utilisateurs"},
     *     summary="Update a proprietaire",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the utilisateurs edit Status",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"statut"},
     *             @OA\Property(property="statut", type="string" ,example="Inactif"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * ) 
     */

    public function updateStatus($id, Request $request)
    {
        $validator =   Validator::make($request->all(), [
            'statut' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ], 422);
        }
        $utilisateur = Utilisateur::find($id);
        try{
            $this->authorize('update', $utilisateur) ;
        }catch(Exception $e){
            return response()->json([
                'statusCode' => 403,
                'message' => 'probleme d\'authorisation',
                'error' => $e->getMessage()
            ], 403);
        }
        if ($utilisateur) {
            $utilisateur->statut = $request->statut;
            $utilisateur->save();
            return response()->json([
                'statusCode' => 200,
                'message' => 'status modifier avec success',
                'data' => $utilisateur
            ], 200);
        } else {
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\' avons pas trouver de  utilisateur avec cette id',
            ], 404);
        }
    }

    private function  validateUtilisateur($request){
        $validator =   Validator::make($request->all(), [
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'addresse' => 'required|string',
            'sexe' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }else{
        return  null ; 
        }

    }
}
