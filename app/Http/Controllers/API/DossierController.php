<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
class DossierController extends Controller
{
    public function index()
    {
        $user = auth()->user();
      
        $doses = Dossier::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $doses
        ]);
    }
    public function show($id)
    {
        $user = auth()->user();
      
        $doses = Dossier::with('user','procedure')->find($id);

        return response()->json([
            'status' => 'success',
            'data' => $doses
        ]);
    }
    public function saveSignature(Request $request, $id)
{
    try {
        $dose = Dossier::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'signature' => 'required|string',
        ]);
       


        // Decode base64 signature
        $signatureData = base64_decode($request->signature);
        
        // Generate unique filename
        $filename = 'signature_' . $id . '_' . time() . '.png';
        
        // Save the signature image
        $path = Storage::disk('public')->put('signatures/' . $filename, $signatureData);
        
        if (!$path) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save signature'
            ], 500);
        }

        // Update the dose with signature path
        $dose->update([
            'signature' => 'signatures/' . $filename
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Signature saved successfully',
            'data' => [
                'signature_path' => $dose->signature
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
} 