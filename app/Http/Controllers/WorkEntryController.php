<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WorkEntry;
use Illuminate\Http\Request;

class WorkEntryController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::orderBy('name')->get();

        $q = WorkEntry::with('project')
            ->where('user_id', $request->user()->id);

        if ($request->filled('project_id')) {
            $q->where('project_id', $request->project_id);
        }
        if ($request->filled('from')) {
            $q->whereDate('work_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $q->whereDate('work_date', '<=', $request->to);
        }

        $workEntries = $q->orderBy('work_date', 'desc')->paginate(10);

        return view('work_entries.index', compact('projects', 'workEntries'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('work_entries.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id'   => 'nullable|exists:projects,id',
            'project_name' => 'nullable|string|max:255',
            'work_date'    => 'nullable|date',
            'hours'        => 'required|integer|min:1|max:24',
            'description'  => 'nullable|string',
        ]);

        // Resolver el proyecto: usar id si viene, o crear/buscar por nombre
        $projectId = $data['project_id'] ?? null;

        if (!$projectId) {
            $name = trim($data['project_name'] ?? '');
            if ($name !== '') {
                $projectId = Project::firstOrCreate(['name' => $name])->id;
            }
        }

        if (!$projectId) {
            return back()
                ->withErrors(['project_name' => 'Selecciona o escribe un proyecto.'])
                ->withInput();
        }

        WorkEntry::create([
            'user_id'     => $request->user()->id,
            'project_id'  => $projectId,
            'work_date'   => $data['work_date'] ?? now()->toDateString(),
            'hours'       => $data['hours'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('work-entries.index')->with('status', 'Registro creado');
    }

    public function edit(WorkEntry $workEntry)
    {
        // (opcional) proteger edición de otros usuarios
        if ($workEntry->user_id !== request()->user()->id) {
            abort(403);
        }

        $projects = Project::orderBy('name')->get();
        return view('work_entries.edit', compact('workEntry', 'projects'));
    }

    public function update(Request $request, WorkEntry $workEntry)
    {
        if ($workEntry->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'project_id'   => 'nullable|exists:projects,id',
            'project_name' => 'nullable|string|max:255',
            'work_date'    => 'nullable|date',
            'hours'        => 'required|integer|min:1|max:24',
            'description'  => 'nullable|string',
        ]);

        $projectId = $data['project_id'] ?? null;

        if (!$projectId) {
            $name = trim($data['project_name'] ?? '');
            if ($name !== '') {
                $projectId = Project::firstOrCreate(['name' => $name])->id;
            }
        }

        if (!$projectId) {
            return back()
                ->withErrors(['project_name' => 'Selecciona o escribe un proyecto.'])
                ->withInput();
        }

        $workEntry->update([
            'project_id'  => $projectId,
            'work_date'   => $data['work_date'] ?? $workEntry->work_date,
            'hours'       => $data['hours'],
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('work-entries.index')->with('status', 'Registro actualizado');
    }

    public function destroy(WorkEntry $workEntry)
    {
        if ($workEntry->user_id !== request()->user()->id) {
            abort(403);
        }

        $workEntry->delete();
        return redirect()->route('work-entries.index')->with('status', 'Registro eliminado');
    }
}
