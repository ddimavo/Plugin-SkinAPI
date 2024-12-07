<?php

namespace Azuriom\Plugin\SkinApi\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('skin-api::admin.index', [
            'width' => setting('skin.width', 64),
            'height' => setting('skin.height', 64),
            'scale' => setting('skin.scale', 1),
            'show_nav_icon' => setting('skin.show_nav_icon', true),
            'show_in_profile' => setting('skin.show_in_profile', true),
            'navigation_icon' => setting('skin.navigation_icon', ''),
            'not_found_behavior' => setting('skin.not_found_behavior', 'default_skin'),
        ]);
    }

    public function update(Request $request) {
        $settings = $this->validate($request, [
            'height' => 'required|integer|min:0',
            'width' => 'required|integer|min:0',
            'scale' => 'required|integer|min:0',
            'show_nav_icon' => 'sometimes|boolean',
            'show_in_profile' => 'sometimes|boolean',
            'navigation_icon' => 'nullable|string|max:50',
            'not_found_behavior' => ['required', 'string', 'in:default_skin,error_message'],
        ]);

        // Handle checkbox values
        $settings['show_nav_icon'] = $request->has('show_nav_icon');
        $settings['show_in_profile'] = $request->has('show_in_profile');

        foreach ($settings as $name => $value) {
            Setting::updateSettings("skin.{$name}", $value);
        }

        return redirect()->route('skin-api.admin.index')
            ->with('success', trans('admin.settings.status.updated'));
    }

    /**
     * Show the skins management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function skins()
    {
        return redirect()->route('skin-api.admin.index');
    }

    /**
     * Show the capes management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function capes()
    {
        return view('skin-api::admin.capes', [
            'width' => setting('skin.cape_width', 64),
            'height' => setting('skin.cape_height', 32),
            'show_nav_button' => setting('skin.cape_show_nav_button', true),
            'show_in_profile' => setting('skin.cape_show_in_profile', true),
            'nav_icon' => setting('skin.cape_nav_icon', ''),
            'not_found_behavior' => setting('skin.cape_not_found_behavior', 'default_skin'),
        ]);
    }

    public function updateCapes(Request $request)
    {
        $settings = $this->validate($request, [
            'height' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'show_nav_button' => 'sometimes|boolean',
            'show_in_profile' => 'sometimes|boolean',
            'nav_icon' => 'nullable|string|max:50',
            'not_found_behavior' => ['required', 'string', 'in:default_skin,error_message'],
        ]);

        // Handle checkbox values
        $settings['show_nav_button'] = $request->has('show_nav_button');
        $settings['show_in_profile'] = $request->has('show_in_profile');

        foreach ($settings as $name => $value) {
            Setting::updateSettings("skin.cape_{$name}", $value);
        }

        return redirect()->route('skin-api.admin.capes')
            ->with('success', trans('admin.settings.status.updated'));
    }

    public function removeDefaultCape()
    {
        $path = plugin_path('skin-api').'/assets/img/cape.png';
        
        if (file_exists($path)) {
            unlink($path);
            return redirect()->route('skin-api.admin.capes')
                ->with('success', 'Default cape removed successfully');
        }

        return redirect()->route('skin-api.admin.capes')
            ->with('error', 'No default cape found');
    }

    public function updateDefaultCape(Request $request)
    {
        // First validate basic file requirements
        $this->validate($request, [
            'default_cape' => [
                'required',
                'file',
                'image',
                'mimes:png'
            ],
        ]);

        // Then validate dimensions after we know it's a valid image
        if ($request->hasFile('default_cape')) {
            $file = $request->file('default_cape');
            $width = setting('skin.cape_width', 64);
            $height = setting('skin.cape_height', 32);
            
            $image = getimagesize($file->getPathname());
            if ($image[0] != $width || $image[1] != $height) {
                return redirect()->route('skin-api.admin.capes')
                    ->withErrors(['default_cape' => "The cape must be exactly {$width}x{$height} pixels"]);
            }

            $path = plugin_path('skin-api').'/assets/img';
            
            // Create directory if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Move the uploaded file to the correct location
            $file->move($path, 'cape.png');

            return redirect()->route('skin-api.admin.capes')
                ->with('success', 'Default cape updated successfully');
        }

        return redirect()->route('skin-api.admin.capes')
            ->with('error', 'No file was uploaded');
    }
}
