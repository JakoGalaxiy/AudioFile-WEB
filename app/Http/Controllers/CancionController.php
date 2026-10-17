<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CancionController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://127.0.0.1:8000/api/songs'); 
            $jsonResponse = $response->successful() ? $response->json() : [];
            $songs = $jsonResponse['data'] ?? [];
        } catch (\Exception $e) {
            $songs = [];
        }

        $apiUrl = 'http://127.0.0.1:8000';

        $mappedSongs = collect($songs)->map(function ($song) use ($apiUrl) {
            $songObj = (object) $song;

            // Manejo de la ruta de audio
            if (isset($songObj->file_path)) {
                if (str_starts_with($songObj->file_path, 'http')) {
                    $songObj->file_path = str_replace(['http://localhost', 'https://localhost'], $apiUrl, $songObj->file_path);
                } else {
                    $songObj->file_path = $apiUrl . '/' . ltrim($songObj->file_path, '/');
                }
            }

            // Mapeo seguro del álbum
            if (isset($songObj->album)) {
                $albumObj = is_array($songObj->album) ? (object) $songObj->album : $songObj->album;
                
                // Manejo de la carátula
                if (isset($albumObj->cover_url)) {
                    if (str_starts_with($albumObj->cover_url, 'http')) {
                        $albumObj->cover_url = str_replace(['http://localhost', 'https://localhost'], $apiUrl, $albumObj->cover_url);
                    } else {
                        $albumObj->cover_url = $apiUrl . '/' . ltrim($albumObj->cover_url, '/');
                    }
                }

                // Mapeo seguro del artista dentro del álbum
                if (isset($albumObj->artist)) {
                    $artistObj = is_array($albumObj->artist) ? (object) $albumObj->artist : $albumObj->artist;
                    $albumObj->artist = $artistObj;
                }

                $songObj->album = $albumObj;
            }

            return $songObj;
        });

        $recentSongs = $mappedSongs;
        $trendingSongs = $mappedSongs;
        $forYouSongs = $mappedSongs;
        $discoveryGenre = $mappedSongs;
        $discoveryArtist = $mappedSongs;

        return view('home', compact('recentSongs', 'trendingSongs', 'forYouSongs', 'discoveryGenre', 'discoveryArtist'));
    }
}