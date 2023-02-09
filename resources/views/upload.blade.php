<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('auth.files') }} <span class="text-gray-400">({{ 0 }})</span>
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

                    <form action="{{route('uploads')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center p-5 border-2 border-gray-300 rounded-lg">
                            <input type="file" name="file" id="file" >

                        </div>
                        <button type="submit" class="mt-5 bg-yellow-500 text-white p-2 rounded-lg hover:bg-indigo-600">Upload</button>
                    </form>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>

