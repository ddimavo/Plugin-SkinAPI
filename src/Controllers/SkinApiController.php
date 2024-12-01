<?php

namespace Azuriom\Plugin\SkinApi\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\SkinApi\SkinAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SkinApiController extends Controller
{
    /**
     * Show the home plugin page.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('skin-api::index', [
            'skinUrl' => route('skin-api.api.show', $request->user()->id).'?v='.Str::random(4),
        ]);
    }

    public function update(Request $request)
    {
        if (!$request->hasFile('skin')) {
            return redirect()->back()->withErrors(['skin' => 'No file uploaded']);
        }

        $file = $request->file('skin');
        if (!$file->isValid()) {
            return redirect()->back()->withErrors(['skin' => 'Invalid file upload']);
        }

        // Validate file type and basic requirements
        $this->validate($request, [
            'skin' => ['required', 'file', 'mimes:png'],
        ]);

        // Get image dimensions
        $imageInfo = @getimagesize($file->getPathname());
        if (!$imageInfo) {
            return redirect()->back()->withErrors(['skin' => 'Unable to read image dimensions']);
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $constraints = SkinAPI::getConstraints();

        // Strict dimension check based on settings
        if (isset($constraints['width']) && isset($constraints['height'])) {
            if ($width !== (int)$constraints['width'] || $height !== (int)$constraints['height']) {
                return redirect()->back()->withErrors(['skin' => "Skin dimensions must be exactly {$constraints['width']}x{$constraints['height']} pixels"]);
            }
        } else {
            if ($width < $constraints['min_width'] || $height < $constraints['min_height'] ||
                $width > $constraints['max_width'] || $height > $constraints['max_height']) {
                return redirect()->back()->withErrors(['skin' => "Skin dimensions must be between {$constraints['min_width']}x{$constraints['min_height']} and {$constraints['max_width']}x{$constraints['max_height']} pixels"]);
            }
        }

        try {
            // Create storage directory if it doesn't exist
            $storagePath = storage_path('app/public/skins');
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }

            // Move the file directly using move
            $fileName = $request->user()->id . '.png';
            $file->move($storagePath, $fileName);

            return redirect()->back()->with('success', trans('skin-api::messages.status.updated'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['skin' => 'Failed to save skin file: ' . $e->getMessage()]);
        }
    }
}
