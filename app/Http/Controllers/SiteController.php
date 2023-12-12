<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Services\AuthUserService;
use App\Store\SiteStore;
use Core\UseCases\Sites;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    private Sites $sites;

    public function __construct(SiteStore $siteStore, AuthUserService $authUserService)
    {
        $this->middleware('auth:api', ['except' => ['getSite', 'getState', 'updateState']]);
        $this->sites = new Sites($siteStore, $authUserService);
    }

    public function index()
    {
        return $this->sites->getAll();
    }

    public function updateState(Request $request)
    {
        try {
            $this->sites->updateState($request->input('id'), $request->input('state'));

            return response()->json([
                'message' => 'state update',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'state not update',
            ], 404);
        }
    }

    public function store(StoreSiteRequest $request)
    {
        try {
            $this->sites->save($request->all());

            return response()->json([
                'message' => 'Successfully created',
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Failed to create',
                'error' => $error->getMessage(),
            ], 500);
        }
    }

    public function getSitesForCurrentUser()
    {
        $sites = $this->sites->getSitesForCurrentUser();

        return response()->json([
            'sites' => $sites,
        ], 200);
    }

    public function getSites($userId)
    {
        $sites = $this->sites->getSitesByUser($userId);

        return response()->json([
            'sites' => $sites,
        ], 200);
    }

    public function getState($url)
    {
        $site = $this->sites->getState($url);
        if ($site) {
            return response()->json([
                'id' => $site->id,
                'state' => $site->state,
            ], 200);
        } else {
            return response()->json(['message' => 'Site not found'], 404);
        }
    }

    public function getSite(string $id)
    {
        $site = $this->sites->getSite($id);

        return response()->json([
            'site' => $site,
        ], 200);
    }
}
