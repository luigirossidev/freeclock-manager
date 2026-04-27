<?php

namespace App\Http\Controllers;

use App\Models\Firmware;
use Illuminate\Http\Request;

class ApiFWController extends Controller
{
    // Controlla la versione del firmware in base al device code, restituisce la versione più alta
    public function version(Request $request, $mobile = false)
    {
        app()->setLocale($request->get('lang', 'it'));

        // Controlla se il device code è presente
        if (!$request->has('device') || $request->device == null) {
            die("Invalid Request");
        }

        // Cerca il firmware più recente per il device code
        $firmware = Firmware::where('device_code', $request->device)
            ->where('is_active', 1)
            ->orderBy('version', 'desc')->first();

        if ($firmware == null) {
            die("No firmware found");
        }

        if ($mobile) {
            return response()->json([
                'latest' => $firmware->version,
                'notes' => $firmware->notes,
            ]);
        }else{
            // ritorna la versione del firmware in formato HTML anziché JSON
            return response($firmware->version);
        }
    }

    // Restituisce il firmware in base al device code
    public function download(Request $request)
    {
        if (!$request->has('device') || $request->device == null) {
            die("Invalid Request");
        }

        $firmware = Firmware::where('device_code', $request->device)
            ->where('is_active', 1)
            ->orderBy('version', 'desc')->first();

        if ($firmware == null) {
            die("No firmware found");
        }

        $filePath = storage_path('app/public/' . $firmware->bin_file);
        $fileSize = filesize($filePath);
        $fileName = $firmware->device_code . '_' . $firmware->version . '.bin';

        return response(file_get_contents($filePath), 200, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Length'      => $fileSize,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

}
