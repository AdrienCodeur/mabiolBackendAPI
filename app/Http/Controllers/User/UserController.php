<?php

namespace App\Http\Controllers\User;

use App\Events\CreateUtilisateurEvent;
use App\Events\RegisterUser;
use App\Http\Controllers\Controller;
use App\Mail\RegisterUserMail;
use App\Models\User;
use App\Models\Utilisateur;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function checkAuth(Request $request)
    {
        if (auth()->check()) {
            // L'utilisateur est authentifié
            return response()->json([
                'statusCode' => 200,
                'data' => auth()->user(),
            ]);
        } else {
            // L'utilisateur n'est pas authentifié
            return response()->json([
                'authenticated' => false,
                'statusCode' => 401,
                'message' => 'Utilisateur non authentifié.',
            ], 401);
        }
    }
    /** 
     * @OA\Post(
     *     path="/api/v1/user/login",
     *     tags={"User"},
     *     summary="login  user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *         )
     *     ),
     *     @OA\Response(response="201", description="TypeUser created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */

    public function doLoginUser(Request $request)
    {
        // validation de donnees de connection 
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ], 422);
        }

        try {
            $user =  User::where('email', $request->email)->first();
            //  return $user ;
            if ($user && Hash::check($request->password, $user->password)) {
                $token =    $user->createToken('privatekey')->plainTextToken;
                return   response()->json([
                    'message' => "utilisateur connecter",
                    "data" => $user,
                    'token' => $token
                ], 203);
            }

            return   response()->json([
                'message' => "Identifiant de connetion inconnue",
                'statusCode' => 401
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /** 
     * @OA\Post(
     *     path="/api/v1/user/register",
     *     tags={"User"},
     *     summary="Create a new  user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password" ,"name"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="TypeUser created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public  function store(Request $request)
    {
        // valider les donnees 
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 401,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ]);
        }
        try {

            $user =  new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->save();
            //  event(new RegisterUser($user)) ;
            //  $event = new CreateUtilisateurEvent()  ;
            //   event($event) ;
            // TODO revenir ici apres
            // Mail::to($user->email)->send(new RegisterUserMail($user));
            return response()->json([
                'statusCode' => 200,
                'message' => "user creer avec success",
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    // use Illuminate\Support\Facades\Auth;

    // Pour un 'user'
    // if (Auth::guard('user')->attempt($credentials)) {
    //     $token = Auth::guard('user')->user()->createToken('Token Name')->accessToken;
    //     // Retourner le token
    // }

    // Pour un 'utilisateur'

    // 'providers' => [
    //     'users' => [
    //         'driver' => 'eloquent',
    //         'model' => App\Models\User::class,
    //     ],
    //     'utilisateurs' => [
    //         'driver' => 'eloquent',
    //         'model' => App\Models\Utilisateur::class,
    //     ],
    // ],
    // 'guards' => [
    //     'user' => [
    //         'driver' => 'token',
    //         'provider' => 'users',
    //     ],
    //     'utilisateur' => [
    //         'driver' => 'token',
    //         'provider' => 'utilisateurs',
    //     ],
    // ],

    /** 
     * @OA\Post(
     *     path="/api/v1/utilisateurs/login",
     *     tags={"User"},
     *     summary="route pour login les bailleurs  comme  les locataires ",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email" ,"password"},
     *             @OA\Property(property="email", type="string") ,
     *             @OA\Property(property="password", type="string") ,
     *         )
     *     ),
     *     @OA\Response(response="201", description="TypeUser created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function loginUtilisateur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'statusCode' => 422,
                'message' => 'probleme de validation de donnee',
                'error' => $validator->errors()
            ], 422);
        }


        $user =  Utilisateur::where('email', $request->email)
            ->with(["typeUser" => function ($query) {
                $query->select('id', 'libelle');
            }])->first();


        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token =    $user->createToken('privateekey')->plainTextToken;
                return   response()->json([
                    'message' => "utilisateur  connecter",
                    "data" => $user,
                    'token' => $token
                ], 200);
            } else {
                return   response()->json([
                    'message' => "Identifiant de connection inconnue",
                    'statusCode' => 423
                ], 423);
            }
        } else {
            return   response()->json([
                'message' => "nous n'avons pas trouver d'utilisateurs avec cette addresse email ",
                "statusCode" => 404,
            ], 404);
        }
    }
}
