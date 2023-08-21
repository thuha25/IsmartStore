<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class AdminSliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        if ($status === 'public') {
            $sliders = Slider::where('status', 'Công khai')->get();
        } else if ($status ===  'pending') {
            $sliders = Slider::where('status', 'Chờ duyệt')->get();
        } else {
            $sliders = Slider::orderBy('position')->get();
        }
        $count_slider_all = Slider::count();
        $count_slider_public = Slider::where('status', 'Công khai')->count();
        $count_slider_pending = Slider::where('status', 'Chờ duyệt')->count();
        $count = [$count_slider_all, $count_slider_public, $count_slider_pending];
        return view('admin.slider.list', compact('sliders', 'count'));
    }
    function add(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|max:2048',
            ],
            [
                'required' => ':attribute không được để trống.',
                'file.required' => 'Hình ảnh không được để trống.',
                'file.max' => 'Hình ảnh không được vượt quá kích thước 2MB.',
            ],
            [
                'file' => 'Hình ảnh',
            ]
        );
        $file = $request->file('file');
        $filename  = $file->getClientOriginalName();
        $file->move(public_path('images/silder'), $filename);
        $data = [
            'status' => $request->input('status'),
            'user_id' => auth()->user()->id,
            'position' => Slider::count() + 1,
            'created_by' => auth()->user()->name,
            'created_at' => now()

        ];
        if (isset($filename)) {
            $data['image_url'] = 'images/silder/' . $filename;
        }
        $slider = Slider::create($data);
        $slider->save();
        return redirect()->route('admin.slider.list')->with('success', 'Slider đã được thêm thành công!');
    }
    function delete($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        return redirect()->route('admin.slider.list')->with('success', 'Slider đã được xoá thành công!');
    }
    public function up($id)
    { 
        $slider = Slider::findOrFail($id);
        $currentPosition = $slider->position;
        if ($currentPosition > 1) {
            $previousSlider = Slider::where('position', $currentPosition - 1)->first();
            if ($previousSlider) {
                $slider->update(['position' => $currentPosition - 1]);
                $previousSlider->update(['position' => $currentPosition]);
            }
        }
        return redirect('admin/slider/list')->with('success','Vị trí hiển thị ảnh đã được thay đổi');
    }
}
