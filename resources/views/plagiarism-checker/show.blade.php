<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Plagiarism Checker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(isset($results) && is_array($results) && count($results))
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">File 1</th>
                                    <th class="px-4 py-2 border">File 2</th>
                                    <th class="px-4 py-2 border">Similarity</th>
                                    <th class="px-4 py-2 border">Similarity Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    usort($results, function($a, $b) {
                                        return $b['similarity_score'] <=> $a['similarity_score'];
                                    });
                                @endphp
                                @foreach($results as $result) 
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border">{{ $result['file1'] }}</td>
                                        <td class="px-4 py-2 border">{{ $result['file2'] }}</td>
                                        <td class="px-4 py-2 border">{{ $result['similarity'] }}</td>
                                        <td class="px-4 py-2 border">{{ $result['similarity_score'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p>No results to display.</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
