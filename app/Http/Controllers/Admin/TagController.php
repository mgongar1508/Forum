<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name', 'desc')->get();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:50', 'unique:tags,name'],
            'color' => ['required', 'color'],
        ]);

        Tag::create($validated);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:50', 'unique:tags,name,'. $tag->id],
            'color' => ['required', 'color'],
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete($tag->id);

        return redirect()->route('tags.index')->with('success', 'Tag deleted.');
    }
}
