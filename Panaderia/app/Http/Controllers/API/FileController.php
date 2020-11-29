<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Vyuldashev\LaravelOpenApi\Annotations as OpenApi;

/**
 * @OpenApi\PathItem()
 */
class FileController extends Controller
{
    /**
     * Retrieves an File
     *
     * Retrieves the file based on its ID
     * @OpenApi\Operation(tags="files")
     * @OpenApi\Response(factory="FileResponse", statusCode=200)
     * @OpenApi\Response(factory="ErrorNotFoundResponse", statusCode=404)
     */
    public function show(Request $request, int $id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }
        $url = '';

        if ($file->disk == 's3') {
            $url = Storage::disk('s3')->temporaryUrl($file->path, now()->addMinutes(5));
        } elseif ($file->disk == 'public') {
            $url = Storage::disk('public')->url($file->path);
        } else {
            return response()->file(Storage::disk('local')->path($file->path));
        }

        return $request->wantsJson() ? response()->json(['url' => $url]) : response()->redirectTo($url);
    }

    public static function getUrlOrId(int $id)
    {
        $file = File::find($id);
        if (!$file)
            return null;

        if ($file->disk == 's3')
            return Storage::disk('s3')->temporaryUrl($file->path, now()->addMinutes(5));
        elseif ($file->disk == 'public')
            return Storage::disk('public')->url($file->path);

        return $id;
    }
}
