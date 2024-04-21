<?php

namespace App\Http\Controllers\Utilisateur;

use App\Http\Controllers\Controller;
use App\Http\Requests\UtilisateurRequest;
use App\Models\TypeUser;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LocataireController extends Controller
{
    //

    /**
     * @OA\Get(
     *     path="/api/v1/locataire",
     *     tags={"Locataires"},
     *     summary="Liste des  locataires",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des   utilisateurs  récupérée avec succès"
     *     )
     * )
     */
    public function index()
    {
        try {
            //code...
            $locataire =  Utilisateur::with('typeUser')->whereHas('typeUser', function ($query) {
                $query->where('libelle', 'Locataire');
            })->get();
            return response()->json([
                'statusCode' => 200,
                'message' => "locataire recuperer  success",
                'data' => $locataire
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     */ /**
     * @OA\Put(
     *     path="/api/v1/locataire/edit/{id}",
     *     tags={"Locataires"},
     *     summary="Update a utilisateurs",
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
     *             @OA\Property(property="email", type= "string" , example="djeudjeschool@gmail.com"),
     *             @OA\Property(property="telephone", type="string",example="+237 650513914"),
     *             @OA\Property(property="addresse", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="nom",type="string",example="djeudje tenkeu"),
     *             @OA\Property(property="sexe",type="string",example="Masculin"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * ) 
     */
    public function  editLocataire(Request $request, $id)
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
                    ]);
                } else {
                    return response()->json([
                        'statusCode' => 422,
                        'message' => "utilisateurs na pas ete  mis a jour"
                    ], 422);
                }
            } catch (Exception $e) {
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'un probleme est survenu',
                    'error' => $e->getMessage()
                ]);
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
     *     path="/api/v1/locataire/create",
     *     tags={"Locataires"},
     *     summary="Create a new  locataire",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password" ,"nom","telephone","addresse"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *             @OA\Property(property="nom", type="string" ,example="adrien kevin") ,
     *             @OA\Property(property="sexe", type="string") ,
     *             @OA\Property(property="telephone", type="string" ,example="+237 651503914") ,
     *             @OA\Property(property="addresse", type="string" ,example="RSA") ,
     *         )
     *     ),
     *     @OA\Response(response="201", description="utilisateurs created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function createLocataire(Request $request)
    {
        $validator =   Validator::make($request->all(), [
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'addresse' => 'required|string',
            'sexe' => 'required|string',
            // 'type_user_id' => 'exists:type_users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 203,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {
            $typeUser = TypeUser::where("libelle", "Locataire")->first();
            $newUtilisateur =   new Utilisateur();
            $newUtilisateur->email = $request->email;
            $newUtilisateur->nom = $request->nom;
            $newUtilisateur->telephone = $request->telephone;
            $newUtilisateur->addresse = $request->addresse;
            $newUtilisateur->type_user = $typeUser->id;
            $newUtilisateur->login = $request->email;
            $newUtilisateur->sexe = $request->sexe;
            $newUtilisateur->slug = $request->nom;
            $newUtilisateur->statut = 'actif';
            $newUtilisateur->deleted_at =  new Carbon();
            $newUtilisateur->password = Hash::make($request->password);

            $newUtilisateur->save();
            if ($newUtilisateur) {
                $newUtilisateur->type_user = $typeUser->libelle;
                return response()->json([
                    'statusCode' => 200,
                    'message' => "locataire creer avec success",
                    'data' =>  $newUtilisateur,
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
            ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/locataire/show/{id}",
     *     tags={"Locataires"},
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
    public function showLocataire($id)
    {
        $utilisateurId = Utilisateur::with('typeUser')->whereHas('typeUser', function ($query) {
            $query->where('libelle', 'Locataire');
        })->find($id);
        try {
            if ($utilisateurId) {
                return   response()->json([
                    'statusCode' => 200,
                    'message' => "locataire  recuperer en particulier  avec success",
                    'data' => $utilisateurId
                ]);
            } else {
                return   response()->json([
                    'statusCode' => 203,
                    'message' => "nous n'avons pas trouver de locataire   avec l'identifiant unique passer",
                ]);
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
     *     path="/api/v1/locataire/delete/{id}",
     *     tags={"Locataires"},
     *     summary="Delete a locataire",
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
    public function deleteLocataire(string $id)
    {
        $utilisateurs = Utilisateur::find($id);
        if ($utilisateurs) {
            $utilisateurs->deleted_at = Carbon::now();
            $utilisateurs->save();
            return response()->json([
                'message' => "locataire suprimer avec succcess",
                "statusCode" => 202
            ], 202);
        }
        return response()->json([
            'message' => "nous n'avons pas trouver de utilisateurs avec cette id",
            "statusCode" => 404
        ], 404);
        return response()->json([
            'message' => "nous n'avons pas trouver de utilisateurs avec cette id",
            "statusCode" => 404
        ], 404);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/locataire/getProprietaires/{locataire_id}",
     *     tags={"Locataires"},
     *     summary="Liste tous les proprietaires d'un locataires en passant l'id  du locataires",
     *     @OA\Parameter(
     *         name="locataire_id",
     *         in="path",
     *         required=true,
     *         description=" id de utilisateurs",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */

    public function getProprietaire($locataire_id)
    {
        $id = $locataire_id;
        $utilisateur = Utilisateur::find($id);
        if ($utilisateur) {
            $result = $utilisateur->proprietaires;
            return response()->json([
                "statusCode" => 200,
                "message" => "nous avons recuperer les proprietaires  du  locataire  avec l'Id passer",
                "data" => $result
            ]);
        } else {
            return response()->json([
                "statusCode" => 404,
                "message" => "nous n'avons pas trouver de proprietaire  pour le locataire avec identifiant"
            ], 404);
        }
    }
}
