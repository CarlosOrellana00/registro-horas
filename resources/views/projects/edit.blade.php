<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Editar proyecto</h2></x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('projects.update',$project) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label>Nombre</label>
                <input name="name" class="border p-2 w-full" value="{{ old('name',$project->name) }}">
                @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Descripción</label>
                <textarea name="description" class="border p-2 w-full">{{ old('description',$project->description) }}</textarea>
            </div>

            <button class="px-3 py-2 bg-blue-600 text-white rounded">Actualizar</button>
            <a href="{{ route('projects.index') }}" class="px-3 py-2 bg-gray-300 rounded">Volver</a>
        </form>
    </div>
</x-app-layout>
