<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $drive;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Google_Client $client)
    {
        $this->middleware(function ($request, $next) use ($client) {
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listFiles = $this->listFiles();
        } catch (\Exception $e) {
            return redirect()->to('/')->with('error' , 'Daily Limit expired');
        }
        return view('home', compact('listFiles'));
    }

    /**
     * @return array|mixed
     */
    public function listFiles()
    {
        try {
            $result = [];
            $pageToken = NULL;

            $three_months_ago = now()->subMonths(3)->toRfc3339String();

            $parameters = [
                'q' => "viewedByMeTime >= '$three_months_ago' or modifiedTime >= '$three_months_ago'",
                'orderBy' => 'modifiedTime',
                'fields' => 'nextPageToken, files(id, name, modifiedTime, iconLink, webViewLink, webContentLink)',
            ];

            if ($pageToken) {
                $parameters['pageToken'] = $pageToken;
            }

            $result = $this->drive->files->listFiles($parameters);
            $files = ($result->files) ? $result->files : [];
            return $files;
        } catch (\Exception $e) {
            return [];
        }
    }

}
