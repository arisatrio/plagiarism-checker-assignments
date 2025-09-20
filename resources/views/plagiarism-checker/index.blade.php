<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Results') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg">{{ __('Plagiarism Checker Result') }}</h3>
                    <hr>
                    <a 
                        href="{{ route('plagiarism-checker.create') }}"
                        class="mt-4 inline-block px-4 py-2 rounded text-white font-semibold" style="background-color: #10b981 !important; border-color: #10b981 !important;">
                        Check New Assignment
                    </a>
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white border border-gray-300 dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Assignment Title</th>
                                    <th class="px-4 py-2 border">Date</th>
                                    <th class="px-4 py-2 border">Total Files</th>
                                    <th class="px-4 py-2 border">Total Comparisons</th>
                                    <th class="px-4 py-2 border">Avg Similarity</th>
                                    <th class="px-4 py-2 border">Checked At</th>
                                    <th class="px-4 py-2 border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($summaries as $key => $summary)
                                        <tr class="border-b dark:border-gray-700 hover:bg-green-50 dark:hover:bg-gray-900">
                                            <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 border font-semibold">{{ $summary->assignment_title }}</td>
                                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($summary->assignment_date)->format('d F Y') }}</td>
                                            <td class="px-4 py-2 border text-center">{{ $summary->total_files }}</td>
                                            <td class="px-4 py-2 border text-center">{{ $summary->total_comparisons }}</td>
                                            <td class="px-4 py-2 border text-center">
                                                <span class="inline-block px-2 py-1 rounded font-bold"
                                                    @if ($summary->average_similarity >= $summary->threshold) style="background-color: #f87171; color: white;" @endif
                                                    @if ($summary->average_similarity < $summary->threshold && $summary->average_similarity >= ($summary->threshold - 0.1)) style="background-color: #fbbf24; color: white;" @endif
                                                    @if ($summary->average_similarity < ($summary->threshold - 0.1)) style="background-color: #34d399; color: white;" @endif
                                                >{{ round($summary->average_similarity * 100, 2) }}%</span>
                                            </td>
                                            <td class="px-4 py-2 border text-center">{{ \Carbon\Carbon::parse($summary->checked_at)->format('d F Y H:i:s') }}</td>
                                            <td class="px-4 py-2 border text-center">
                                                <a href="{{ route('plagiarism-checker.show', $summary->id) }}" class="inline-block px-3 py-1 rounded text-white font-semibold" style="background-color: #10b981 !important; border-color: #10b981 !important;">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-4 py-2 text-center">No results found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
