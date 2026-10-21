<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendPreviewController extends Controller
{
    public function index(Request $request): View
    {
        $fixtures = require resource_path('fixtures/frontend.php');
        $state = $request->query('state', 'ready');

        if (! is_string($state) || ! array_key_exists($state, $fixtures['states'])) {
            abort(404);
        }

        return view('pages.home', [
            'screen' => [
                'meta' => $fixtures['meta'],
                'state' => $state,
                'viewer' => $fixtures['viewers']['guest'],
                'events' => $state === 'ready' ? array_slice($fixtures['events'], 0, 3) : [],
                'message' => $fixtures['states'][$state],
            ],
        ]);
    }

    public function admin(): View
    {
        $fixtures = require resource_path('fixtures/frontend.php');

        return view('pages.admin', [
            'screen' => [
                'meta' => $fixtures['meta'],
                'state' => 'ready',
                'viewer' => $fixtures['viewers']['admin'],
                'events' => $fixtures['events'],
            ],
        ]);
    }
}
