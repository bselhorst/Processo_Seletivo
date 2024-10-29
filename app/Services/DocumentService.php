<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DocumentService {
    public function saveDocumentEnrolled($id, $localizacao, $fileReceived)
    {
        // Log::channel('stderr')->info("Iniciou");
        if (@$fileReceived){
            foreach($fileReceived as $key => $file)
            {
                $fileName = \Str::random(128) . '.'.$file->extension();
                $file->storeAs("public/inscricao/$id/$localizacao", "$fileName");
            }
        }
    }
}

