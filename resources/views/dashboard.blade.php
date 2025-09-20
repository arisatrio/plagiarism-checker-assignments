<x-app-layout>
    <x-slot name="header">
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full">
                <div class="flex space-x-8 mb-8">
                    <div class="flex-1 bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalAssignments }}</div>
                        <div class="text-gray-700 dark:text-gray-300">Total Assignments Checked</div>
                    </div>
                    <div class="flex-1 bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $totalFiles }}</div>
                        <div class="text-gray-700 dark:text-gray-300">Total Files Processed</div>
                    </div>
                    <div class="flex-1 bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-col items-center">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $averageSimilarity }}%</div>
                        <div class="text-gray-700 dark:text-gray-300">Average Similarity</div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-4">
                    <h3 class="font-semibold text-lg mb-4">Recent Assignment Checks</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white border border-gray-300 dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-2 border">Title</th>
                                    <th class="px-4 py-2 border">Date</th>
                                    <th class="px-4 py-2 border">Files</th>
                                    <th class="px-4 py-2 border">Comparisons</th>
                                    <th class="px-4 py-2 border">Avg Similarity</th>
                                    <th class="px-4 py-2 border">Checked At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSummaries as $summary)
                                    <tr class="border-b dark:border-gray-700 hover:bg-green-50 dark:hover:bg-gray-900">
                                        <td class="px-4 py-2 border font-semibold">{{ $summary->assignment_title }}</td>
                                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($summary->assignment_date)->format('d F Y') }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $summary->total_files }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $summary->total_comparisons }}</td>
                                        <td class="px-4 py-2 border text-center">{{ round($summary->average_similarity * 100, 2) }}%</td>
                                        <td class="px-4 py-2 border text-center">{{ \Carbon\Carbon::parse($summary->checked_at)->format('d F Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
