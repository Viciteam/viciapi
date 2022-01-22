<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Storage;


class uploadController extends Controller
{

  public function upload(Request $request){
    $validator = Validator::make($request->all(), [
    'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($validator->fails()) {
      $response = [
          'message' => $validator->messages()->first(),
      ];

      $code = 500;

      return response($response, $code);
    }
    $uploadFolder = 'users';
    $image = $request->file('image');
    $image_uploaded_path = $image->store($uploadFolder, 'public');
    $response = array(
      "image_name" => basename($image_uploaded_path),
      "image_url" => Storage::disk('public')->url($image_uploaded_path),
      "mime" => $image->getClientMimeType()
    );
    $code = 200;

    return response($response, $code);
  }

}
