<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Plagiarism Checker') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a 
                href="{{ route('plagiarism-checker.index') }}"
                class="mb-4 inline-block px-4 py-2 rounded text-white font-semibold" style="background-color: #6b7280 !important; border-color: #6b7280 !important;">
                Back to Results
            </a>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="font-semibold text-lg">{{ __('Plagiarism Checker Result') }}</h3>
                        <hr>
                    </div>

                    <div class="mb-4">
                        <table class="table border mb-4" style="width:75%; float:left;"> 
                            <thead>
                                <tr class="border-b">
                                    <th class="border" width="25%">Assignment Title</th>
                                    <td class="border p-2">{{ $summary->assignment_title }} </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Assignment Date</th>
                                    <td class="border p-2">{{ \Carbon\Carbon::parse($summary->assignment_date)->format('d F Y') }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Shingle Size</th>
                                    <td class="border p-2">{{ $summary->shingle_size }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Total Files</th>
                                    <td class="border p-2">{{ $summary->total_files }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Total Comparisons</th>
                                    <td class="border p-2">{{ $summary->total_comparisons }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Similarity Threshold</th>
                                    <td class="border p-2">{{ $summary->threshold }}%</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Execution Time</th>
                                    <td class="border p-2">{{ $summary->execution_time }} seconds</td>
                                </tr>
                                <tr>
                                    <th class="border">Checked At</th>
                                    <td class="border p-2">{{ \Carbon\Carbon::parse($summary->checked_at)->format('d F Y H:i:s') }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border" width="25%">Average Similarity Score (%)</th>
                                    <td class="border p-2">{{ round($summary->average_similarity * 100, 2) }}%</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Highest Similarity Score (%)</th>
                                    <td class="border p-2">{{ round($summary->highest_similarity * 100, 2) }}%</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="border">Lowest Similarity Score (%)</th>
                                    <td class="border p-2">{{ round($summary->lowest_similarity * 100, 2) }}%</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="mb-4" style="clear:both;">
                        <h3 class="font-semibold text-lg">{{ __('Comparison Results') }}</h3>
                        <p class="text-sm">
                            <span class="mr-2"><span style="color:red;">*</span>Results are cached for 24 hours.</span>
                        </p>
                        <hr>
                    </div>

                    <div class="mb-4">
                        <a 
                            href="{{ url()->current() }}?recalculate=1"
                            class="ml-4 inline-block px-4 py-2 rounded text-white font-semibold" style="background-color: #f59e0b !important; border-color: #f59e0b !important;">
                            Recalculate
                        </a>
                        <a 
                            href="#"
                            class="ml-4 inline-block px-4 py-2 rounded text-white font-semibold" style="background-color: #3b82f6 !important; border-color: #3b82f6 !important;">
                            Export to Excel
                        </a>
                        <a 
                            href="{{ route('plagiarism-checker.create') }}"
                            class="ml-4 inline-block px-4 py-2 rounded text-white font-semibold" style="background-color: #10b981 !important; border-color: #10b981 !important;">
                            New Comparison
                        </a>
                    </div>

                    @if($results->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Test Document (File 1)</th>
                                    <th class="px-4 py-2 border">Comparison Document (File 2)</th>
                                    <th class="px-4 py-2 border">Jaccard Similarity <br> (0-1)</th>
                                    <th class="px-4 py-2 border">Similarity Score <br> (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $key => $result) 
                                    <tr class="hover:bg-green-50 dark:hover:bg-gray-900">
                                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border">{{ $result->file1 }}</td>
                                        <td class="px-4 py-2 border">{{ $result->file2 }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $result->similarity }}</td>
                                        <td
                                            @php $score = floatval(preg_replace('/[^\d.]+/', '', $result->similarity_score)); @endphp
                                            @if ($score >= floatval($summary->threshold)) style="background-color: #f87171; color: white;" @endif
                                            @if ($score < floatval($summary->threshold) && $score >= (floatval($summary->threshold) - 10)) style="background-color: #fbbf24; color: white;" @endif
                                            @if ($score < (floatval($summary->threshold) - 10)) style="background-color: #34d399; color: white;" @endif
                                        class="px-4 py-2 border text-center">{{ $result->similarity_score }}</td>
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
