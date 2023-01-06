<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\SaveSportNewsTask;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ImportSportNewsAction extends Action
{
    public function run(array $sports)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $baseUrl = config('appSection-system.base_url');

        foreach ($sports as $sport) {
            $sportName = self::makeSportSlag($sport['name']);

            $url = $baseUrl . $sportName . "/news/";

            $crawler = $client->request('GET', $url);

            $crawler->filter('.news-list .news-list__headline-link')->each(function($node) use ($client, $sport) {
                if ($node->attr('href')) {
                    $crawler2 = $client->request('GET', $node->attr('href'));

                    $title = $this->getTitle($crawler2);

                    if (!empty($title)) {
                        $data = [
                            'sport_id' => $sport['id'],
                            'link' => $node->attr('href'),
                            'title' => $title
                        ];

                        $this->getInfo($crawler2, $data);
                        $this->getImage($crawler2, $data);
                        $this->getDate($crawler2, $data);
                        app(SaveSportNewsTask::class)->run($data);
                    }
                }
            });
        }
    }

    private function getTitle($crawler)
    {
        $title = '';

        $crawler->filter('.sdc-article-header__long-title')->each(function($node) use( &$title) {
            $title = $node->text();
        });

        return $title;
    }

    private function getInfo($crawler, &$data)
    {
        $data['info'] = '';

        $crawler->filter('.sdc-article-body p')->each(function($node) use(&$data) {
            $data['info'] .= $node->text();
        });
    }

    private function getImage($crawler, &$data)
    {
        $firstImage = true;

        $crawler->filter('.sdc-article-image__item')->each(function($node) use(&$data, &$firstImage) {
            if ($firstImage && $node->attr('src') != '') {
                $data['image'] = $node->attr('src');
                $firstImage = false;
            }
        });
    }

    private function getDate($crawler, &$data)
    {
        $crawler->filter('.sdc-article-date__date-time')->each(function($node) use(&$data) {
            $originalDate = explode(",", $node->text());
            $formattedDate = date("Y-m-d H:i:s", strtotime($originalDate[0]));
            $data['news_date'] = $formattedDate;
        });
    }

    private static function makeSportSlag($item)
    {
        $item = preg_replace("/[^\w]/", "-", strtolower(trim($item)));
        switch ($item) {
            case 'other':
                return 'more-sports';
            case 'formula-1':
                return 'f1';
            default:
                return $item;
        }
    }
}
