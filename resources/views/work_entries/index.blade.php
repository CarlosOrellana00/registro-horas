<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Registros de horas</h2></x-slot>

    <div class="p-6 space-y-4">
        <div class="flex items-end gap-2">
            <form method="GET" class="flex items-end gap-2">
                <div>
                    <label>Proyecto</label>
                    <select name="project_id" class="border p-2">
                        <option value="">Todos</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}" @selected(request('project_id')==$p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div><label>Desde</label><input type="date" name="from" value="{{ request('from') }}" class="border p-2"></div>
                <div><label>Hasta</label><input type="date" name="to" value="{{ request('to') }}" class="border p-2"></div>
                <button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrar</button>
                <a href="{{ route('work-entries.index') }}" class="px-3 py-2 bg-gray-300 rounded">Limpiar</a>
            </form>

            <a href="{{ route('work-entries.create') }}" class="ml-auto px-3 py-2 bg-blue-600 text-white rounded">Nuevo</a>
        </div>

        @if (session('status')) <p class="text-green-700">{{ session('status') }}</p> @endif

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Fecha</th>
                    <th class="p-2 text-left">Proyecto</th>
                    <th class="p-2 text-left">Horas</th>
                    <th class="p-2 text-left">Descripción</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workEntries as $e)
                    <tr class="border-t">
                        <td class="p-2">{{ $e->work_date->format('Y-m-d') }}</td>
                        <td class="p-2">{{ $e->project->name }}</td>
                        <td class="p-2">{{ $e->hours }}</td>
                        <td class="p-2">{{ $e->description }}</td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('work-entries.edit',$e) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">Editar</a>
                            <form method="POST" action="{{ route('work-entries.destroy',$e) }}" onsubmit="return confirm('¿Eliminar registro?')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t"><td class="p-2" colspan="5">Sin registros aún.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div>{{ $workEntries->links() }}</div>
    </div>
</x-app-layout>
