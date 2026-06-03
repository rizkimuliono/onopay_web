<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait ApiValidation
{
    /**
     * Validate API request and return JSON errors on failure
     */
    protected function validateApi(Request $request, array $rules, array $messages = [])
    {
        try {
            return $request->validate($rules, $messages);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422)->throwResponse();
        }
    }
}
