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
        ]);
    }

    public function update(Request $request) {
        $settings = $this->validate($request, [
            'height' => 'required|integer|min:0',
            'width' => 'required|integer|min:0',
            'scale' => 'required|integer|min:0',
        ]);

        foreach ($settings as $name => $value) {
            Setting::updateSettings("skin.{$name}", $value);
        }

        return redirect()->route('skin-api.admin.home')
            ->with('success', trans('admin.settings.status.updated'));
    }

    /**
     * Show the skins management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function skins()
    {
        return redirect()->route('skin-api.admin.home');
    }

    /**
     * Show the capes management page (currently inactive).
     *
     * @return \Illuminate\Http\Response
     */
    public function capes()
    {
        return abort(404);
    }
}
