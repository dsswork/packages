<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class ApiAnswerService
{
    public static function successfulAnswer(string $status = Response::HTTP_OK)
    {
        return response()->json(['status' => 'success'], $status);
    }

    public static function successfulAnswerWithData(array $data, string $status = Response::HTTP_OK)
    {
        return response()->json(array_merge(['status' => 'success'], $data), $status);
    }

    public static function errorAnswer($message, $status = null)
    {
        if (!$status) {
            $status = 200;
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => $message
            ],
            $status
        );
    }

}
