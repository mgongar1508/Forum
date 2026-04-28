<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subforum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubforumController extends Controller
{
    public function index()
    {
        $subforums = Subforum::orderBy('name', 'desc')->get();

        return view('admin.subforums.index', compact('subforums'));
    }

    public function create()
    {
        return view('admin.subforums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:subforums,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Subforum::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'post_count' => 0,
        ]);

        return redirect()->route('subforums.index')->with('success', 'Subforum created successfully.');
    }

    public function edit(Subforum $subforum)
    {
        return view('admin.subforums.edit', compact('subforum'));
    }

    public function update(Request $request, Subforum $subforum)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:subforums,name,'.$subforum->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $subforum->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('subforums.index')->with('success', 'Subforum updated successfully.');
    }

    public function destroy(Subforum $subforum)
    {
        $subforum->delete($subforum->id);

        return redirect()->route('subforums.index')->with('success', 'Subforum deleted.');
    }
}
