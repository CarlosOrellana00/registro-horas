<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Projects</h2>
    </x-slot>

    <div class="p-6">
        <div class="flex justify-end mb-4">
            <a href="{{ route('projects.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded">Nuevo</a>
        </div>

        <table class="min-w-full bg-white">
            <thead>
            <tr class="border-b">
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Descripción</th>
                <th class="p-2 text-left w-48">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($projects as $p)
                <tr class="border-b">
                    <td class="p-2">{{ $p->name }}</td>
                    <td class="p-2 text-gray-600">
                        {{ \Illuminate\Support\Str::limit($p->description, 120) }}
                    </td>
                    <td class="p-2">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('projects.edit', $p) }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded">Editar</a>

                            <form method="POST" action="{{ route('projects.destroy', $p) }}"
                                  onsubmit="return confirm('¿Eliminar este proyecto? También se borrarán sus horas.');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-4 text-center text-gray-500" colspan="3">
                        Sin proyectos aún.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $projects->links() }}
        </div>
    </div>
</x-app-layout>
