<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendPreviewController extends Controller
{
    public function index(Request $request): View
    {
        $screen = $this->screen($request);
        $fixtures = require resource_path('fixtures/frontend.php');
        $screen['profile'] = $fixtures['profiles']['complete'];
        $screen['events'] = $screen['state'] === 'ready' ? array_slice($screen['events'], 0, 3) : [];

        return view('pages.home', compact('screen'));
    }

    public function catalog(Request $request): View
    {
        $screen = $this->screen($request);
        // Fixed examples only; catalog filtering and business rules belong to later tasks.
        $screen['events'] = array_slice($screen['events'], 0, 3);

        return view('pages.catalog', compact('screen'));
    }

    public function saved(Request $request): View|RedirectResponse
    {
        $screen = $this->screen($request);
        if ($screen['viewer']['role'] === 'guest') {
            return redirect()->route('login', ['next' => 'saved']);
        }
        $fixtures = require resource_path('fixtures/frontend.php');
        $screen['events'] = array_values(array_filter(
            $screen['events'],
            fn (array $event) => in_array($event['id'], $fixtures['saved_event_ids'], true),
        ));

        return view('pages.saved', compact('screen'));
    }

    public function profile(Request $request): View|RedirectResponse
    {
        $screen = $this->screen($request);
        if ($screen['viewer']['role'] === 'guest') {
            return redirect()->route('login', ['next' => 'profile']);
        }
        $fixtures = require resource_path('fixtures/frontend.php');
        $screen['profile'] = $fixtures['profiles']['complete'];

        return view('pages.profile', compact('screen'));
    }

    public function login(Request $request): View
    {
        $screen = $this->screen($request);
        $next = $request->query('next', 'home');
        // Named destinations prevent a demo link becoming an external redirect.
        if (! is_string($next) || ! in_array($next, ['home', 'saved', 'profile'], true)) {
            abort(404);
        }

        return view('pages.login', compact('screen', 'next'));
    }

    public function components(Request $request): View
    {
        return view('pages.components', ['screen' => $this->screen($request)]);
    }

    public function admin(Request $request): View
    {
        $screen = $this->screen($request);
        $fixtures = require resource_path('fixtures/frontend.php');
        $screen['viewer'] = $fixtures['viewers']['admin'];
        $screen['persona'] = ['as' => 'admin'];

        return view('pages.admin', compact('screen'));
    }

    private function screen(Request $request): array
    {
        $fixtures = require resource_path('fixtures/frontend.php');
        $state = $request->query('state', 'ready');
        $persona = $request->query('as', 'guest');

        if (! is_string($state) || ! array_key_exists($state, $fixtures['states'])
            || ! is_string($persona) || ! array_key_exists($persona, $fixtures['viewers'])) {
            abort(404);
        }

        return [
            'meta' => $fixtures['meta'],
            'state' => $state,
            'viewer' => $fixtures['viewers'][$persona],
            'persona' => $persona === 'guest' ? [] : ['as' => $persona],
            'events' => $fixtures['events'],
            'message' => $fixtures['states'][$state],
        ];
    }
}
