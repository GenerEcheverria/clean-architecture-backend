<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\UseCases\Sites;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests\StoreSiteRequest;
use App\Store\SiteStore;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'getIdSite', 'updateState']]);
    }

    public function index(SiteStore $siteStore)
    {
        $sites = new Sites($siteStore);
        return $sites->getAll();
    }

    public function updateState(Request $request, SiteStore $siteStore)
    {
        try {
            $sites = new Sites($siteStore);
            $sites->updateState($request->input('id'), $request->input('state'));
            return response()->json([
                "message" => "state update",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "state not update",
            ], 404);
        }
    }

    public function store(StoreSiteRequest $request, SiteStore $siteStore)    {
        try {
            $sites = new Sites($siteStore);
            $user = JWTAuth::parseToken()->authenticate();
            $sites->save($request, $user);
            return response()->json([
                'message' => 'Successfully created',
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Failed to create',
                'error' => $error->getMessage()
            ], 500);
        }
    }
    
    public function getSitesForCurrentUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sites = $user->sites;
        return response()->json([
            'sites' => $sites
        ], 200);
    }
    
    public function getSites($userId, SiteStore $siteStore)
    {
        $sites = $siteStore->getSites($userId);
        return response()->json([
            'sites' => $sites
        ], 200);
    }

    public function getIdSite($url, SiteStore $siteStore)
    {
        $site = $siteStore->findByUrl($url);

        if ($site) {
            return response()->json([
                'id' => $site->id,
                'state' => $site->state
            ], 200);
        } else {
            return response()->json(['message' => 'Site not found'], 404);
        }
    }
    
    public function show(string $id, SiteStore $siteStore, Sites $sites)
    {
        $site = $siteStore->findById($id);
        $buildedSite = $sites->buildSite($site);
        return response()->json([
            'newCrearSitio' => $buildedSite //Cambiar nombre en el front al modificar este
        ], 200);
    }
}
