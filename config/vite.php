<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vite Manifest Path
    |--------------------------------------------------------------------------
    |
    | Path ke file manifest.json hasil build Vite.
    | Default Laravel nyari di public/build/manifest.json,
    | tapi kalau hasil build masuk ke public/build/.vite/manifest.json
    | kita arahkan ke situ.
    |
    */

    'manifest' => public_path('build/.vite/manifest.json'),

    /*
    |--------------------------------------------------------------------------
    | Vite Build Path
    |--------------------------------------------------------------------------
    |
    | Folder hasil build Vite yang akan dipakai untuk load asset.
    |
    */

    'build_path' => public_path('build'),

];
