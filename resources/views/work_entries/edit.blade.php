<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Editar registro</h2></x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('work-entries.update',$entry) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label>Proyecto</label>
                <input
                    type="text"
                    name="project_name"
                    list="projects"
                    class="border p-2 w-full"
                    placeholder="Escribe o selecciona un proyecto"
                    value="{{ old('project_name', $workEntry->project->name) }}"
                >

                <datalist id="projects">
                  @foreach($projects as $p)
                      <option value="{{ $p->name }}"></option>
                  @endforeach
                </datalist>

                @error('project_name') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Fecha</label>
                <input type="date" name="work_date" class="border p-2 w-full" value="{{ old('work_date', $entry->work_date->format('Y-m-d')) }}">
            </div>
            <div>
                <label>Horas</label>
                <input type="number" name="hours" min="1" max="24" class="border p-2 w-full" value="{{ old('hours',$entry->hours) }}">
            </div>
            <div>
                <label>Descripción</label>
                <textarea name="description" class="border p-2 w-full">{{ old('description',$entry->description) }}</textarea>
            </div>

            <button class="px-3 py-2 bg-blue-600 text-white rounded">Actualizar</button>
            <a href="{{ route('work-entries.index') }}" class="px-3 py-2 bg-gray-300 rounded">Volver</a>
        </form>
    </div>
</x-app-layout>
