<?php

namespace App\Store;

use App\Models\Body;
use App\Models\Footer;
use App\Models\Header;
use App\Models\Image;
use App\Models\Site;
use App\Models\Text;
use App\Models\User;
use App\Models\Video;
use Core\Interfaces\ISiteStore;
use Illuminate\Support\Facades\DB;

class SiteStore implements ISiteStore
{
    public function getAll()
    {
        return Site::all();
    }

    public function isSiteStored(int $id): bool
    {
        return Site::where('id', $id)->exists();
    }

    public function updateState(int $id, string $state)
    {
        $site = Site::find($id);
        $site->state = $state;
        $site->save();
    }

    public function save($siteInput, $user)
    {
        try {
            $siteData = [
                'idUser' => $user->id,
                'name' => $siteInput['newCrearSitio']['name'],
                'backgroundColor' => $siteInput['newCrearSitio']['backgroundColor'],
                'views' => $siteInput['newCrearSitio']['views'],
                'url' => $siteInput['newCrearSitio']['url'],
                'state' => 'publicada',
            ];
            DB::beginTransaction();
            $site = Site::create($siteData);
            $headerData = [
                'idSite' => $site->id,
                'title' => $siteInput['newCrearSitio']['header']['title'],
                'size' => $siteInput['newCrearSitio']['header']['size'],
                'position' => $siteInput['newCrearSitio']['header']['position'],
                'color' => $siteInput['newCrearSitio']['header']['color'],
                'image' => $siteInput['newCrearSitio']['header']['image'],
                'hero' => $siteInput['newCrearSitio']['header']['hero'],
            ];
            $bodyDataContent = $siteInput['newCrearSitio']['body'];
            foreach ($bodyDataContent as $index => $item) {
                $bodyData = [
                    'idSite' => $site->id,
                    'indexPage' => $index,
                ];
                $body = Body::create($bodyData);
                echo $body;
                if (isset($item['full'])) {
                    if (isset($item['full']['text'])) {
                        $textData = [
                            'idCol' => $body->id,
                            'titleText' => $item['full']['text']['title'],
                            'positionTitle' => $item['full']['text']['position'],
                            'text' => $item['full']['text']['text'],
                            'positionText' => $item['full']['text']['alignment'],
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
                            'text' => $item['full']['image']['caption'],
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
                            'size' => $item['full']['video']['size'],
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
                            'positionText' => $item['left']['text']['alignment'],
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
                            'text' => $item['left']['image']['caption'],
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
                            'size' => $item['left']['video']['size'],
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
                            'positionText' => $item['right']['text']['alignment'],
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
                            'text' => $item['right']['image']['caption'],
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
                            'size' => $item['right']['video']['size'],
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
                'backgroundColor' => $siteInput['newCrearSitio']['footer']['backgroundColor'],
                'textColor' => $siteInput['newCrearSitio']['footer']['textColor'],
                'setSocialMedia' => $siteInput['newCrearSitio']['footer']['socialMedia']['setSocialMedia'],
                'facebook' => $siteInput['newCrearSitio']['footer']['socialMedia']['facebook'],
                'twitter' => $siteInput['newCrearSitio']['footer']['socialMedia']['twitter'],
                'instagram' => $siteInput['newCrearSitio']['footer']['socialMedia']['instagram'],
                'tiktok' => $siteInput['newCrearSitio']['footer']['socialMedia']['tiktok'],
                'linkedin' => $siteInput['newCrearSitio']['footer']['socialMedia']['linkedin'],
                'otro' => $siteInput['newCrearSitio']['footer']['socialMedia']['otro'],
                'setContact' => $siteInput['newCrearSitio']['footer']['contact']['setContact'],
                'address' => $siteInput['newCrearSitio']['footer']['contact']['address'],
                'phone' => $siteInput['newCrearSitio']['footer']['contact']['phone'],
                'setExtra' => $siteInput['newCrearSitio']['footer']['extra']['setExtra'],
                'text' => $siteInput['newCrearSitio']['footer']['extra']['text'],
                'image' => $siteInput['newCrearSitio']['footer']['extra']['image'],
            ];
            $footer = Footer::create($footerData);
            echo $footer;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Error during site creation: '.$e->getMessage(), 500);
        }
    }

    public function getSitesForCurrentUser($user)
    {
        $sites = $user->sites;

        return $sites;
    }

    public function getSitesByUser($userId)
    {
        $user = User::findOrFail($userId);
        $sites = $user->sites;

        return $sites;
    }

    public function getState($url)
    {
        return Site::where('url', $url)->first();
    }

    public function getSite($id)
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
