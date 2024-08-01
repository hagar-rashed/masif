<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Repositories\Contract\SettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {

        $this->settingRepository = $settingRepository;
    } // end of contruct

    public function edit()
    {

        $settings = $this->settingRepository->getAll(['column' => 'id', 'dir' => 'ASC']);

        return view('dashboard.settings.edit', compact('settings'));
    } // end of create

    public function update(SettingRequest $request)
    {
        $attribute = $request->except('_token', '_method', 'logo', 'footer_logo', 'favicon');

        $logo        = $this->settingRepository->getWhere([['key', 'logo']])->first()['value'];
        $footer_logo = $this->settingRepository->getWhere([['key', 'footer_logo']])->first()['value'];
        $favicon     = $this->settingRepository->getWhere([['key', 'favicon']])->first()['value'];
        $main_video  = $this->settingRepository->getWhere([['key', 'main_video']])->first()['value'];
        $map_image   = $this->settingRepository->getWhere([['key', 'map_image']])->first()['value'];

        if ($request->has('logo')) {

            // Delete old internal_image
            Storage::delete($logo);

            // Upload new internal_image
            $attribute['logo'] = $request->file('logo')->store('setting');
        }

        if ($request->has('footer_logo')) {

            // Delete old internal_image
            Storage::delete($footer_logo);

            // Upload new internal_image
            $attribute['footer_logo'] = $request->file('footer_logo')->store('setting');
        }

        if ($request->has('favicon')) {

            // Delete old internal_image
            Storage::delete($favicon);

            // Upload new internal_image
            $attribute['favicon'] = $request->file('favicon')->store('setting');
        }

        if ($request->has('main_video')) {

            // Delete old internal_image
            Storage::delete($main_video);

            // Upload new internal_image
            $attribute['main_video'] = $request->file('main_video')->store('setting');
        }

        if ($request->has('map_image')) {

            // Delete old internal_image
            Storage::delete($map_image);

            // Upload new internal_image
            $attribute['map_image'] = $request->file('map_image')->store('setting');
        }

        $this->settingRepository->updateSetting($attribute);

        return redirect()->back()->with('success', __('models.update_success'));
    } // end of update
}
