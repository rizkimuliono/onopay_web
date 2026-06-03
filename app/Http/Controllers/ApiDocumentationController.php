<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    public function index(Request $request)
    {
        // Get the current base URL for API
        $protocol = $request->secure() ? 'https' : 'http';
        $host = $request->getHost();
        $baseUrl = "{$protocol}://{$host}/api/v1";

        return view('api-documentation.index', [
            'baseUrl' => $baseUrl
        ]);
    }
}
