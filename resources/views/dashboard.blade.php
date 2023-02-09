<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('auth.files') }} <span class="text-gray-400">({{ $files->count() }})</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-8">
                    <form action="{{ route('dashboard') }}" method="get" class="pb-4">
                        <div class="form-group">
                            <input
                                type="text"
                                name="q"
                                class="form-control"
                                placeholder="Search..."
                                value="{{ request('q') }}"
                            />
                        </div>
                    </form>

                    @forelse ($files as $file)

                        <article class="space-y-1">
                            <h2 class="font-semibold text-2xl">{{ $file->doc_name }}</h2>

                            <p class="m-0">{{ $file->doc_content }}</body>

                            <div>
                                <span class="text-xs px-2 py-1 rounded bg-indigo-50 text-indigo-500">{{ $file->doc_type}}</span>
                            </div>
                        </article>
                    @empty
                        <p>No articles found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

