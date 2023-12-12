<?php

namespace Core\UseCases;

use Core\Interfaces\IAuthUser;
use Core\Interfaces\ISiteStore;

class Sites
{
    private $siteStore;

    private $authUser;

    public function __construct(ISiteStore $siteStore, IAuthUser $auth)
    {
        $this->siteStore = $siteStore;
        $this->authUser = $auth;
    }

    public function getAll()
    {
        return $this->siteStore->getAll();
    }

    public function updateState($id, $state)
    {
        if ($this->siteStore->isSiteStored($id)) {
            $this->siteStore->updateState($id, $state);
        }
    }

    public function save(array $site)
    {
        $user = $this->authUser->authenticate();
        $this->siteStore->save($site, $user);
    }

    public function getSitesForCurrentUser()
    {
        $user = $this->authUser->authenticate();

        return $this->siteStore->getSitesForCurrentUser($user);
    }

    public function getSitesByUser($userId)
    {
        return $this->siteStore->getSitesByUser($userId);
    }

    public function getState($url)
    {
        return $this->siteStore->getState($url);
    }

    public function getSite($id)
    {
        $site = $this->siteStore->getSite($id);
        $name = $site['name'];
        $arreglo = [];
        $arreglo[] = $name;
        $siteBuilded = (object) [
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
                'hero' => ($site->headers[0]->hero == 0) ? false : true,
                'image' => ($site->headers[0]->image == null) ? '' : $site->headers[0]->image,
            ],
            'footer' => [
                'backgroundColor' => $site->footers[0]->backgroundColor,
                'textColor' => $site->footers[0]->textColor,
                'socialMedia' => [
                    'setSocialMedia' => ($site->footers[0]->setSocialMedia == 0) ? false : true,
                    'facebook' => ($site->footers[0]->facebook == null) ? '' : $site->footers[0]->facebook,
                    'instagram' => ($site->footers[0]->instagram == null) ? '' : $site->footers[0]->instagram,
                    'twitter' => ($site->footers[0]->twitter == null) ? '' : $site->footers[0]->twitter,
                    'linkedin' => ($site->footers[0]->linkedin == null) ? '' : $site->footers[0]->linkedin,
                    'tiktok' => ($site->footers[0]->tiktok == null) ? '' : $site->footers[0]->tiktok,
                    'otro' => ($site->footers[0]->otro == null) ? '' : $site->footers[0]->otro,
                ],
                'contact' => [
                    'setContact' => ($site->footers[0]->setContact == 0) ? false : true,
                    'phone' => ($site->footers[0]->phone == null) ? '' : $site->footers[0]->phone,
                    'address' => ($site->footers[0]->address == null) ? '' : $site->footers[0]->address,
                ],
                'extra' => [
                    'setExtra' => ($site->footers[0]->setExtra == 0) ? false : true,
                    'text' => ($site->footers[0]->text == null) ? '' : $site->footers[0]->text,
                    'image' => ($site->footers[0]->image == null) ? '' : $site->footers[0]->image,
                ],

            ],
        ];
        foreach ($site->bodies as $bodyItem) {
            if (is_null($bodyItem->type2)) {
                if ($bodyItem->type === 'text') {
                    $siteBuilded->body[] = [
                        'full' => [
                            'text' => [
                                'alignment' => $bodyItem->texts[0]->positionTitle,
                                'position' => $bodyItem->texts[0]->positionText,
                                'text' => $bodyItem->texts[0]->titleText,
                                'title' => $bodyItem->texts[0]->text,
                            ],
                        ],
                    ];
                } elseif ($bodyItem->type === 'image') {
                    $siteBuilded->body[] = [
                        'full' => [
                            'image' => [
                                'caption' => $bodyItem->images[0]->text,
                                'image' => $bodyItem->images[0]->url,
                                'size' => $bodyItem->images[0]->size,
                            ],
                        ],
                    ];
                } elseif ($bodyItem->type === 'video') {
                    $siteBuilded->body[] = [
                        'full' => [
                            'video' => [
                                'video' => $bodyItem->videos[0]->url,
                                'size' => $bodyItem->videos[0]->size,
                            ],
                        ],
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
                                'title' => $bodyItem->texts[0]->text,
                            ],
                        ],
                    ];
                } elseif ($bodyItem->type === 'image') {
                    $elements = (object) [
                        'left' => [
                            'image' => [
                                'caption' => $bodyItem->images[0]->text,
                                'image' => $bodyItem->images[0]->url,
                                'size' => $bodyItem->images[0]->size,
                            ],
                        ],
                    ];
                } elseif ($bodyItem->type === 'video') {
                    $elements = (object) [
                        'left' => [
                            'video' => [
                                'video' => $bodyItem->videos[0]->url,
                                'size' => $bodyItem->videos[0]->size,
                            ],
                        ],
                    ];
                }
                if ($bodyItem->type2 === 'text') {
                    $siteBuilded->backgroundColor = 'owo';
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
                            'title' => $bodyItem->texts[$index]->text,
                        ],
                    ];
                } elseif ($bodyItem->type2 === 'image') {
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
                        ],
                    ];
                } elseif ($bodyItem->type2 === 'video') {
                    if (is_null($bodyItem->videos) || count($bodyItem->videos) > 1) {
                        $index = 1;
                    } else {
                        $index = 0;
                    }
                    $elements->right = [
                        'video' => [
                            'video' => $bodyItem->videos[$index]->url,
                            'size' => $bodyItem->videos[$index]->size,
                        ],
                    ];
                }
                $siteBuilded->body[] = $elements;
            }
        }

        return $siteBuilded;
    }
}
