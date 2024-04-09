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
    public function index() { 
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
                'message'=> 'un probleme est survenu ',
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
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="telephone", type="string"),
 *             @OA\Property(property="type_user_id", type="string"),
 *             @OA\Property(property="slug", type="string"),
 *             @OA\Property(property="addresse", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="statut", type="string"),
 *         )
 *     ),
 *     @OA\Response(response="200", description="User updated"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="422", description="Validation error")
 * ) 
  */
    public function  editUtilisateur(Request $request ,$id) {

        // return $request ;
        $utilisateurId =  Utilisateur::find($id)  ;
        if($utilisateurId){
            $validator =   Validator::make($request->all() ,[
                'email' => [ 'required' , 'email ' , Rule::unique('utilisateurs')->ignore($utilisateurId->id), ],
                'password' => 'required|min:5',
                'nom' => 'required|string',
                'telephone' => 'required|string',
                'addresse' => 'required|string',
                'sexe' => 'required|string',
                'login' => 'required|string',
                'statut' => 'required|string',
                'slug' => 'required|string',
                'type_user_id' => 'required|exists:type_users,id'
            ])  ;
             
            if($validator->fails()){
                return response()->json([
                    'statusCode' => 203,
                    'message' => ' probleme de validation de donnee',
                    'error' => $validator->errors()
                ]);
    
            }
           try {
              $utilisateurUpdate =    $utilisateurId->update($validator->validated()) ;
              if($utilisateurUpdate){
                return response()->json([
                    'statusCode' => 200,
                    'message' => "utilisateurs mis a jour  success",
                    'data' => $utilisateurUpdate
                ]);
              }else{
                return response()->json([
                    'statusCode' => 204,
                    'message' => "utilisateurs na pas ete  mis a jour"
                ]);
              }
           }catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenu ',
                'error' => $e->getMessage()
            ]);
        }
        }else{
            return response()->json([
                'statusCode' => 404,
                'message' => 'nous n\'avons pas trouver utilisateur avec cette id',
            ]);
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
        *             @OA\Property(property="nom", type="string") ,
        *             @OA\Property(property="sexe", type="string") ,
        *             @OA\Property(property="login", type="string") ,
        *             @OA\Property(property="slug", type="string") ,
        *             @OA\Property(property="statut", type="string") ,
        *             @OA\Property(property="type_user_id", type="string") ,
        *         )
        *     ),
        *     @OA\Response(response="201", description="utilisateurs created"),
        *     @OA\Response(response="422", description="Validation error")
        * )
        */
    public function createLocataire(Request $request)
    {
        $validator =   Validator::make($request->all() ,[
            'email' => 'required|string|email|unique:utilisateurs,email',
            'password' => 'required|min:5',
            'nom' => 'required|string',
            'telephone' => 'required|string',
            'addresse' => 'required|string',
            'sexe' => 'required|string',
            'login' => 'required|string',
            'statut' => 'required|string',
            'slug' => 'required|string',
            // 'type_user_id' => 'exists:type_users,id'
        ])  ;
         
        if($validator->fails()){
            return response()->json([
                'statusCode' => 203,
                'message' => ' probleme de validation de donnee',
                'error' => $validator->errors()
            ]);

        }
        try {
            $typeUser = TypeUser::where("libelle" ,"Locataire")->first() ;
             $newUtilisateur =   new Utilisateur();
            $newUtilisateur->email =$request->email ;
            $newUtilisateur->nom =$request->nom ;
            $newUtilisateur->telephone =$request->telephone ;
            $newUtilisateur->adresse =$request->adresse ;
            $newUtilisateur->slug =$request->slug ;
            $newUtilisateur->type_user_id = $typeUser->id ;
            $newUtilisateur->login = $request->login ;
            $newUtilisateur->sexe = $request->sexe ;
            $newUtilisateur->slug = $request->slug ;
            $newUtilisateur->statut = $request->statut ;
            $newUtilisateur->deleted_at =  new Carbon();
            $newUtilisateur->password = Hash::make($request->password) ;
            
            $newUtilisateur->save() ;
            if ($newUtilisateur) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => "utilisateur creer avec success",
                    'data' => $newUtilisateur
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "utilisateur n'a pas ete creer",
                    // 'data'=>$userUtilisateur   
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
    public function showLocataire($id){
        $utilisateurId = Utilisateur::with('typeUser')->whereHas('typeUser', function ($query) {
            $query->where('libelle', 'Locataire') ;
        })->find($id) ;
        try {
            if($utilisateurId){
            return   response()->json( [
                'statusCode'=>200,
                    'message'=>"locataire  recuperer en particulier  avec success", 
                    'data'=>$utilisateurId
            ]) ;
        }else{
            return   response()->json( [
                'statusCode'=>203,
                    'message'=>"nous n'avons pas trouver de locataire   avec l'identifiant unique passer", 
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
    $utilisateurs =Utilisateur::find($id) ;
    if($utilisateurs){
        $utilisateurs->deleted_at = Carbon::now() ;
        $utilisateurs->save() ;
        return response()->json([
            'message'=>"utilisateurs suprimer avec succcess" ,
            "statusCode"=>203
        ]) ;
    }
    return response()->json([
        'message'=>"nous n'avons pas trouver de utilisateurs avec cette id" ,
        "statusCode"=>404
    ]) ;
}
}
