<?php

namespace App\Store;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use App\Models\Body;
use App\Models\Text;
use App\Models\Image;
use App\Models\Video;
use App\Models\Header;
use App\Models\Footer;
use App\Models\User;

class SiteStore
{
    public function getAll()
    {
        return Site::all();
    }

    public function isSiteStored(Request $request): bool
    {
        return Site::where("id", $request->input('id'))->exists();
    }

    public function updateState(Request $request)
    {
        $site = Site::find($request->input('id'));
        $site->state =  $request->input('state');
        $site->save();
    }

    public function createSite(Request $request, $user)
    {
        try {
            $siteData = [
                'idUser' => $user->id,
                'name' => $request->input('newCrearSitio.name'),
                'backgroundColor' => $request->input('newCrearSitio.backgroundColor'),
                'views' => $request->input('newCrearSitio.views'),
                'url' => $request->input('newCrearSitio.url'),
                'state' => 'publicada'
            ];
            DB::beginTransaction();
            $site = Site::create($siteData);
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
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function getSites($userId)
    {
        $user = User::findOrFail($userId);
        $sites = $user->sites;
        return $sites;
    }

    public function findByUrl($url)
    {
        return Site::where('url', $url)->first();
    }

    public function findById($id)
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
        return $site;
    }
}
