<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\Site;
use App\Models\User;
use App\Models\Body;
use App\Models\Text;
use App\Models\Image;
use App\Models\Video;
use App\Models\Header;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show', 'getIdSite', 'updateState']]);
    }

    /**
     * Get all sites.
     *
     * @return Collection
     */
    public function index()
    {
        return Site::all();
    }

    /**
     * Update the state of a site.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateState(Request $request)
    {
        if (Site::where("id", $request->input('id'))->exists()) {
            $site = Site::find($request->input('id'));
            $site->state =  $request->input('state');
            $site->save();

            return response()->json([
                "message" => "state update",
            ], 200);
        } else {
            return response()->json([
                "error" => "state not update",
            ], 404);
        }
    }

    /**
     * Store a new site with its associated data.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newCrearSitio.name' => 'required|string',
            'newCrearSitio.backgroundColor' => 'required|string',
            'newCrearSitio.views' => 'required|integer',
            'newCrearSitio.url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $siteData = [
            'idUser' => $user->id,
            'name' => $request->input('newCrearSitio.name'),
            'backgroundColor' => $request->input('newCrearSitio.backgroundColor'),
            'views' => $request->input('newCrearSitio.views'),
            'url' => $request->input('newCrearSitio.url'),
            'state' => 'publicada'
        ];

        try {
            DB::beginTransaction();
            $site = Site::create($siteData);

            // Crear un nuevo header para el sitio
            $headerData = [
                'idSite' => $site->id,
                'title' => $request->input('newCrearSitio.header.title'),
                'size' => $request->input('newCrearSitio.header.size'),
                'position' => $request->input('newCrearSitio.header.position'),
                'color' => $request->input('newCrearSitio.header.color'),
                'image' => $request->input('newCrearSitio.header.image'),
                'hero' => $request->input('newCrearSitio.header.hero'),
            ];

            $bodyDataContent = $request->input('newCrearSitio.body');
            foreach ($bodyDataContent as $index => $item) {
                $bodyData = [
                    'idSite' => $site->id,
                    'indexPage' => $index,
                ];
                $body = Body::create($bodyData);
                if (isset($item['full'])) {
                    if (isset($item['full']['text'])) {
                        $textData = [
                            'idCol' => $body->id,
                            'titleText' => $item['full']['text']['title'],
                            'positionTitle' => $item['full']['text']['position'],
                            'text' => $item['full']['text']['text'],
                            'positionText' => $item['full']['text']['alignment']
                        ];
                        $text = Text::create($textData);
                        $body->idType = $text->id;
                        $body->Type = 'text';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['full']['image'])) {
                        $imageData = [
                            'idCol' => $body->id,
                            'url' => $item['full']['image']['image'],
                            'size' => $item['full']['image']['size'],
                            'text' => $item['full']['image']['caption']
                        ];
                        $image = Image::create($imageData);
                        $body->idType = $image->id;
                        $body->Type = 'image';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['full']['video'])) {
                        $videoData = [
                            'idCol' => $body->id,
                            'url' => $item['full']['video']['video'],
                            'size' => $item['full']['video']['size']
                        ];
                        $video = Video::create($videoData);
                        $body->idType = $video->id;
                        $body->Type = 'video';
                        $body->fill($bodyData);
                        $body->save();
                    }
                } elseif (isset($item['left'])) {
                    if (isset($item['left']['text'])) {
                        $textData = [
                            'idCol' => $body->id,
                            'titleText' => $item['left']['text']['title'],
                            'positionTitle' => $item['left']['text']['position'],
                            'text' => $item['left']['text']['text'],
                            'positionText' => $item['left']['text']['alignment']
                        ];
                        $text = Text::create($textData);
                        $body->idType = $text->id;
                        $body->Type = 'text';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['left']['image'])) {
                        $imageData = [
                            'idCol' => $body->id,
                            'url' => $item['left']['image']['image'],
                            'size' => $item['left']['image']['size'],
                            'text' => $item['left']['image']['caption']
                        ];
                        $image = Image::create($imageData);
                        $body->idType = $image->id;
                        $body->Type = 'image';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['left']['video'])) {
                        $videoData = [
                            'idCol' => $body->id,
                            'url' => $item['left']['video']['video'],
                            'size' => $item['left']['video']['size']
                        ];
                        $video = Video::create($videoData);
                        $body->idType = $video->id;
                        $body->Type = 'video';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['right']['text'])) {
                        $textData = [
                            'idCol' => $body->id,
                            'titleText' => $item['right']['text']['title'],
                            'positionTitle' => $item['right']['text']['position'],
                            'text' => $item['right']['text']['text'],
                            'positionText' => $item['right']['text']['alignment']
                        ];
                        $text = Text::create($textData);
                        $body->idType2 = $text->id;
                        $body->Type2 = 'text';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['right']['image'])) {
                        $imageData = [
                            'idCol' => $body->id,
                            'url' => $item['right']['image']['image'],
                            'size' => $item['right']['image']['size'],
                            'text' => $item['right']['image']['caption']
                        ];
                        $image = Image::create($imageData);
                        $body->idType2 = $image->id;
                        $body->Type2 = 'image';
                        $body->fill($bodyData);
                        $body->save();
                    }
                    if (isset($item['right']['video'])) {
                        $videoData = [
                            'idCol' => $body->id,
                            'url' => $item['right']['video']['video'],
                            'size' => $item['right']['video']['size']
                        ];
                        $video = Video::create($videoData);
                        $body->idType2 = $video->id;
                        $body->Type2 = 'video';
                        $body->fill($bodyData);
                        $body->save();
                    }
                }
            }

            $header = Header::create($headerData);

            // Crear un nuevo footer para el sitio
            $footerData = [
                'idSite' => $site->id,
                'backgroundColor' => $request->input('newCrearSitio.footer.backgroundColor'),
                'textColor' => $request->input('newCrearSitio.footer.textColor'),
                'setSocialMedia' => $request->input('newCrearSitio.footer.socialMedia.setSocialMedia'),
                'facebook' => $request->input('newCrearSitio.footer.socialMedia.facebook'),
                'twitter' => $request->input('newCrearSitio.footer.socialMedia.twitter'),
                'instagram' => $request->input('newCrearSitio.footer.socialMedia.instagram'),
                'tiktok' => $request->input('newCrearSitio.footer.socialMedia.tiktok'),
                'linkedin' => $request->input('newCrearSitio.footer.socialMedia.linkedin'),
                'otro' => $request->input('newCrearSitio.footer.socialMedia.otro'),
                'setContact' => $request->input('newCrearSitio.footer.contact.setContact'),
                'address' => $request->input('newCrearSitio.footer.contact.address'),
                'phone' => $request->input('newCrearSitio.footer.contact.phone'),
                'setExtra' => $request->input('newCrearSitio.footer.extra.setExtra'),
                'text' => $request->input('newCrearSitio.footer.extra.text'),
                'image' => $request->input('newCrearSitio.footer.extra.image'),
            ];
            $footer = Footer::create($footerData);

            DB::commit();

            return response()->json([
                'message' => 'Successfully created',
                'site' => $site,
                'header' => $header,
                'footer' => $footer
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all sites associated with the current user.
     *
     * @return JsonResponse
     */
    public function getSitesForCurrentUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $sites = $user->sites;
        return response()->json([
            'sites' => $sites
        ], 200);
    }

    /**
     * Get all sites associated with a specific user.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getSitesForUser($userId)
    {
        $user = User::findOrFail($userId);
        $sites = $user->sites;

        return response()->json([
            'sites' => $sites
        ], 200);
    }


    /**
     * Get the ID of a site based on its URL.
     *
     * @param string $url
     * @return JsonResponse
     */
    public function getIdSite($url)
    {
        $site = Site::where('url', $url)->first();

        if ($site) {
            return response()->json(['id' => $site->id,
            'state' => $site->state
        ], 200);
        } else {
            return response()->json(['message' => 'Site not found'], 404);
        }
    }

    /**
     * Get the details of a site.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $site = Site::findOrFail($id);
        $site->views = $site->views + 1;
        $site->save();
        $site = Site::leftJoin('bodies', 'sites.id', '=', 'bodies.idSite')
            ->leftJoin('headers', 'sites.id', '=', 'headers.idSite')
            ->leftJoin('footers', 'sites.id', '=', 'footers.idSite')
            ->where('sites.id', $id)
            ->select('sites.*', 'bodies.*')
            ->findOrFail($id);
        $bodies = $site->bodies;
        $site = Site::with('bodies.texts', 'bodies.images', 'bodies.videos', 'headers', 'footers')
            ->findOrFail($id);

        $name = $site['name'];
        $arreglo = array();
        $arreglo[] = $name;

        $test = (object) [
            'name' => $site['name'],
            'backgroundColor' => $site['backgroundColor'],
            'views' => $site['views'],
            'url' => $site['url'],
            'id' => $site['id'],
            'idUser' => $site['idUser'],
            'header' => [
                'title' => $site->headers[0]->title,
                'color' => $site->headers[0]->color,
                'position' => $site->headers[0]->position,
                'size' => $site->headers[0]->size,
                'hero' => ($site->headers[0]->hero == 0) ? False : True,
                'image' => ($site->headers[0]->image == null) ? "" : $site->headers[0]->image
            ],
            'footer' => [
                'backgroundColor' => $site->footers[0]->backgroundColor,
                'textColor' => $site->footers[0]->textColor,
                'socialMedia' => [
                    'setSocialMedia' => ($site->footers[0]->setSocialMedia == 0) ? False : True,
                    'facebook' => ($site->footers[0]->facebook == null) ? "" : $site->footers[0]->facebook,
                    'instagram' => ($site->footers[0]->instagram == null) ? "" : $site->footers[0]->instagram,
                    'twitter' => ($site->footers[0]->twitter == null) ? "" : $site->footers[0]->twitter,
                    'linkedin' => ($site->footers[0]->linkedin == null) ? "" : $site->footers[0]->linkedin,
                    'tiktok' => ($site->footers[0]->tiktok == null) ? "" : $site->footers[0]->tiktok,
                    'otro' => ($site->footers[0]->otro == null) ? "" : $site->footers[0]->otro
                ],
                'contact' => [
                    'setContact' => ($site->footers[0]->setContact == 0) ? False : True,
                    'phone' => ($site->footers[0]->phone == null) ? "" : $site->footers[0]->phone,
                    'address' => ($site->footers[0]->address == null) ? "" : $site->footers[0]->address
                ],
                'extra' => [
                    'setExtra' => ($site->footers[0]->setExtra == 0) ? False : True,
                    'text' => ($site->footers[0]->text == null) ? "" : $site->footers[0]->text,
                    'image' => ($site->footers[0]->image == null) ? "" : $site->footers[0]->image
                ]

            ]
        ];
        foreach ($site->bodies as $bodyItem) {
            if (is_null($bodyItem->type2)) {
                if ($bodyItem->type === 'text') {
                    $test->body[] = [
                        'full' => [
                            'text' => [
                                'alignment' => $bodyItem->texts[0]->positionTitle,
                                'position' => $bodyItem->texts[0]->positionText,
                                'text' => $bodyItem->texts[0]->titleText,
                                'title' => $bodyItem->texts[0]->text
                            ]
                        ]
                    ];
                } else if ($bodyItem->type === 'image') {
                    $test->body[] = [
                        'full' => [
                            'image' => [
                                'caption' => $bodyItem->images[0]->text,
                                'image' => $bodyItem->images[0]->url,
                                'size' => $bodyItem->images[0]->size,
                            ]
                        ]
                    ];
                } else if ($bodyItem->type === 'video') {
                    $test->body[] = [
                        'full' => [
                            'video' => [
                                'video' => $bodyItem->videos[0]->url,
                                'size' => $bodyItem->videos[0]->size
                            ]
                        ]
                    ];
                }
            } else {
                if ($bodyItem->type === 'text') {
                    $elements = (object) [
                        'left' => [
                            'text' => [
                                'alignment' => $bodyItem->texts[0]->positionTitle,
                                'position' => $bodyItem->texts[0]->positionText,
                                'text' => $bodyItem->texts[0]->titleText,
                                'title' => $bodyItem->texts[0]->text
                            ]
                        ]
                    ];
                } else if ($bodyItem->type === 'image') {
                    $elements = (object) [
                        'left' => [
                            'image' => [
                                'caption' => $bodyItem->images[0]->text,
                                'image' => $bodyItem->images[0]->url,
                                'size' => $bodyItem->images[0]->size,
                            ]
                        ]
                    ];
                } else if ($bodyItem->type === 'video') {
                    $elements = (object) [
                        'left' => [
                            'video' => [
                                'video' => $bodyItem->videos[0]->url,
                                'size' => $bodyItem->videos[0]->size
                            ]
                        ]
                    ];
                }
                if ($bodyItem->type2 === 'text') {
                    $test->backgroundColor = 'owo';
                    if (is_null($bodyItem->texts) || count($bodyItem->texts) > 1) {
                        $index = 1;
                    } else {
                        $index = 0;
                    }
                    $elements->right = [
                        'text' => [
                            'alignment' => $bodyItem->texts[$index]->positionTitle,
                            'position' => $bodyItem->texts[$index]->positionText,
                            'text' => $bodyItem->texts[$index]->titleText,
                            'title' => $bodyItem->texts[$index]->text
                        ]
                    ];
                } else if ($bodyItem->type2 === 'image') {
                    if (is_null($bodyItem->images) || count($bodyItem->images) > 1) {
                        $index = 1;
                    } else {
                        $index = 0;
                    }
                    $elements->right = [
                        'image' => [
                            'caption' => $bodyItem->images[$index]->text,
                            'image' => $bodyItem->images[$index]->url,
                            'size' => $bodyItem->images[$index]->size,
                        ]
                    ];
                } else if ($bodyItem->type2 === 'video') {
                    if (is_null($bodyItem->videos) || count($bodyItem->videos) > 1) {
                        $index = 1;
                    } else {
                        $index = 0;
                    }
                    $elements->right = [
                        'video' => [
                            'video' => $bodyItem->videos[$index]->url,
                            'size' => $bodyItem->videos[$index]->size
                        ]
                    ];
                }
                $test->body[] = $elements;
            }
        }
        return response()->json([
            'newCrearSitio' => $test
        ], 200);
    }

    /**
     * Update a site.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'backgroundColor' => 'string',
            'views' => 'integer',
            'url' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $site = Site::findOrFail($id);
        $siteData = $validator->validate();
        $site->update($siteData);

        // $name = $site['name'];
        // $arreglo = array();
        // $arreglo[] = $name;
        // $newCrearSitio = [];

        return response()->json([
            'message' => 'Successfully updated',
            'site' => $site
        ], 200);
    }

    /**
     * Delete a site.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $site = Site::findOrFail($id);
        $site->delete();

        return response()->json([
            'message' => 'Successfully deleted',
            'site' => $site
        ], 200);
    }
}
