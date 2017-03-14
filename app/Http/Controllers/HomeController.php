<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function privacy()
    {
      return view('home.privacy');
    }

    public function loadJSON($filename) {
      $path = storage_path() . "/app/public/json/".$filename.".json";

    if (!\File::exists($path)) {
        throw new \Exception("Invalid File");
    }

    $file = \File::get($path);

    return response($file,200);

  }
}
