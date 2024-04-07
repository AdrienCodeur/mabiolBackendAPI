<?php

namespace App\Http\Controllers;

use App\Events\getMessageForUser;
use App\Events\getMessageForUserEvent;
use App\Events\SendMessageForUser;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyMessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/message",
     *     tags={"Message"},
     *     summary="Liste des messages",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des messages récupérée avec succès"
     *     )
     * )
     */

    public function getAllMessages()
    {
        $messages =  Message::all();
        event(new getMessageForUserEvent($messages)) ;
        return response()->json([
            'statusCode' => 200,
            'message' => "message recuperer avec success",
            'data' => $messages
        ]);
    }
    /**
     * @OA\Put(
     *     path="/api/v1/message/edit/{id}",
     *     tags={"Message"},
     *     summary="Update a Message",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Message",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="emetteur_id", type="string", example="3"),
     *             @OA\Property(property="recepteur_id", type="string", example="1"),
     *             @OA\Property(property="contenue", type="string", example="bonsoir le groupe"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function updateMessage(Message $message, MessageRequest $request)
    {
        try {
            $validated = $request->validate();
            $result =   $message->update($validated);
            if ($result) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => "message mis a jour avec success",
                    'data' => $result
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => "modifier  non complet verifier vos donnees",
                    // 'data' => $result
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
     * @OA\Post(
     *     path="/api/v1/message/create",
     *     tags={"Message"},
     *     summary="Create a new message",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contenue"},
     *             @OA\Property(property="recepteur_id",type="string", example="1"),
     *             @OA\Property(property="emetteur_id", type="string", example="3"),
     *             @OA\Property(property="contenue", type="string", example="hello world")
     *         )
     *     ),
     *     @OA\Response(response="201", description="message created"),
     *     @OA\Response(response="422", description="Validation error")
     * )
     */
    public function registerMessage(Request $request)
    {
        $validator =   Validator::make($request->all(), [
            'emetteur_id' => 'required|string|exists:utilisateurs,id',
            'recepteur_id' => 'required|string|exists:utilisateurs,id',
            'contenue' => 'required|string',
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
            // return $request->all() ;
            $message = new  Message();
            $message->recepteur_id = $request->recepteur_id ;
            $message->emetteur_id = $request->emetteur_id ;
            $message->contenue = $request->contenue;
            $message->statut = "unread";
            $message->slug = 'slug';
            $message->save();
            if ($message) {
                event(new SendMessageForUser($message));
                return response()->json([
                    "message" => "message send",
                    "data" => $message
                ]);
                return response()->json([
                    'statusCode' => 200,
                    'message' => "message create  avec success",
                    'data' => $message
                ]);
            } else {
                return response()->json([
                    'statusCode' => 203,
                    'message' => ' probleme  survenue  verifier vos   donnees',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'un probleme est survenue ',
                'error' => $e->getMessage()
            ]);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/v1/message/show/{id}",
     *     tags={"Message"},
     *     summary="Get a specific resource",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description=" id de message",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="404", description="Resource not found")
     * )
     */
    public function showMessage($id)
    {
        $message = Message::find($id);
        if ($message) {
            return   response()->json([
                'statusCode' => 200,
                'message' => "message recuperer avec success",
                'data' => $message
            ]);
        }
        return   response()->json([
            'statusCode' => 404,
            'message' => " nous n'avons pas trouver de message avec cet id"
        ]);
    }
}
