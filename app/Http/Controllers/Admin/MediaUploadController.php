<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;

class MediaUploadController
{

    public function uploadMedia(Request $request)
    {
        $model = $request->input('model');
        $file = $request->file('file');

        $model = new $model();
        $model->exists = true; // Needed because we are adding media to a model that does not exist - yet...
        $media = $model->addMedia($file)->toMediaCollection();

        return response()->json(['media' => $media]);
    }

}
