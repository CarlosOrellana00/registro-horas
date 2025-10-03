<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        Project::create($data);

        return redirect()->route('projects.index')->with('status', 'Proyecto creado.');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $project->update($data);

        return redirect()->route('projects.index')->with('status', 'Proyecto actualizado.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('status', 'Proyecto eliminado.');
    }
}
