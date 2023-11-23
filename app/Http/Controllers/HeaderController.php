<?php

namespace App\Http\Controllers;

use App\Models\header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HeaderController extends Controller
{
    public function index()
    {
        $header = header::all();
        return view('welcome');
    }
    public function create()
    {
        return view('admins.create');
    }
    public function store(Request $request)
    {
        $newName = '';
        $validate = $request->validate([
            'judul' => 'required|max:50',
            'deskripsi' => 'required|max:255',
            'photo' => 'required|mimes:png,jpeg,jpg'
        ]);
        if ($request->file('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $newName = $request->name . '-' . now()->timestamp . '.' . $extension;
            $request->file('photo')->storeAs('public/photo', $newName);
        }
        $request['image'] = $newName;
        $header = header::create($request->all());
        return redirect('admin')->with('flash_message', 'Header Berhasil Ditambahkan');
    }

    public function edit(header $id)
    {
        return view('admins.edit')->with('header', $id);
    }

    public function update(Request $request, $id)
    {
        $header = header::find($id);
        $tambahan = [];

        $validate = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'photo' => 'mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $oldImage = $header->image;


            $ext = $request->image->getClientOriginalExtension();
            $newFileName = time() . '.' . $ext;
            $upload = $request->image->move(public_path() . '/storage/photo', $newFileName);

            if ($upload) {
                $delete = File::delete(public_path() . '/storage/photo' . $oldImage);
                $tambahan = ['image' => $newFileName];
            }
        }
        $header->update($request->except('image') + $tambahan);
        return redirect('admin')->with('flash_message', 'Header Berhasil Diubah');
    }
}
