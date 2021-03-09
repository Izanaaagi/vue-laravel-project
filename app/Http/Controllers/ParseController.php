<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ParseController extends Controller
{
    private $topics = [];

    public function data()
    {
        $client = new Client();
        for ($i = 1; $i <= 192; $i++) {
            $crawler = $client->request('GET', 'https://yummyanime.club/catalog?page=' . $i);
            $crawler->filter('.anime-title')->each(function ($item) {
                array_push($this->topics, $item->text());
            });
        }

        return response()->json(['titles' => $this->topics]);
    }
}
