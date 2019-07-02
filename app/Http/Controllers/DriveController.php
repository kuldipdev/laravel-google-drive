<?php

namespace App\Http\Controllers;

use App\DriveFile;
use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DriveController extends Controller
{
    private $drive;


    /**
     * DriveController constructor.
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->middleware(
            function ($request, $next) use ($client) {
                $client->refreshToken(Auth::user()->refresh_token);
                $this->drive = new Google_Service_Drive($client);
                return $next($request);
            });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function uploadFile(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('upload');
        } else {
            if ($this->createFile($request->file('file'))) {


                return redirect()->route('home')->with('status', 'File Uploaded Sucessfully');
            } else {
                return redirect()->route('home')->with('error', 'File Uploading Failed');
            }
        }
    }


    /**
     * @param $file
     * @param null $parent_id
     * @return bool
     */
    function createFile($file, $parent_id = null)
    {
        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parent' => $parent_id ? $parent_id : 'root'
        ]);

        $content = gettype($file) === 'object' ? File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);

        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id, name',
        ]);
        if ($file->id) {
            DriveFile::create([
                'file_id' => $file->id,
                'file' => $file->name,
            ]);
            return true;
        } else {
            return false;
        }

    }
}
