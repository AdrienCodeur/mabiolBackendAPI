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
        $utilisateurId =  Utilisateur::find($id);
        if ($utilisateurId) {
            $validator =   Validator::make($request->all(), [
                'email' => ['required', 'email ', Rule::unique('utilisateurs')->ignore($utilisateurId->id),],
                'password' => 'required|min:5',
                'nom' => 'required|string',
                'telephone' => 'required|string',
                'addresse' => 'required|string',
                'sexe' => 'required|string',
                // 'type_user_id' => 'required|exists:type_users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 203,
                    'message' => ' probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
            }
            try {
                $utilisateurUpdate =    $utilisateurId->update($validator->validated());
                if ($utilisateurUpdate) {
                    return response()->json([
                        'statusCode' => 200,
                        'message' => "locataire mis a jour  success",
                        'data' => $utilisateurId
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
        $validator =   Validator::make($request->all(), [
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'addresse' => 'required|string',
            'sexe' => 'required|string',
            // 'type_user_id' => 'required|exists:type_users,id'
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
                // $data =  $newUtilisateur->with('typeUser')->first();
                // return $data ;
                return response()->json([
                    'statusCode' => 200,
                    'message' => "utilisateur creer avec success",
                    'data' => $newUtilisateur
                ], 200);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "utilisateur n'a pas ete creer",
                    // 'data'=>$userUtilisateur   
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

    // to create the user and login it directly
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
                $token =    $newUtilisateur->createToken('privateekey')->plainTextToken;

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
     *     path="/api/v1/utilisateurs/show/{id}",
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
    public function showUtilisateur($id)
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
}
