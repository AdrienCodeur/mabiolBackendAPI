<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;

class MyMessageController extends Controller
{
    ////
    public function getAllMessages()
    {
        $messages =  Message::all();
        return response()->json([
            'statusCode' => 200,
            'message' => "message recuperer avec success",
            'data' => $messages
        ]);
    }
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

    public function registerMessage(MessageRequest $request)
    {
        try {
            $validated = $request->validate();
            $message = Message::create($validated);
            if ($message) {
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

    public function showMessage(Message $message)
    {
        return   response()->json([
            'statusCode' => 200,
            'message' => "message recuperer avec success",
            'data' => $message
        ]);
    }
}
