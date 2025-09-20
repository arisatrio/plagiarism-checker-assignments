<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Plagiarism Checker') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg">{{ __('Form Plagiarism Checker Result') }}</h3>

                    <hr>
                    <form action="{{ route('plagiarism-checker.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="title" :value="__('Assignment Title')" required /> 
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Assignment Date')" required /> 
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date') ?? now()->format('Y-m-d')" required autofocus autocomplete="date" />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="template_file" :value="__('Upload Template Assignment File')" /> 
                            <x-text-input id="template_file" class="block mt-1 w-full" type="file" name="template_file" autofocus autocomplete="template_file" />
                            <x-input-error :messages="$errors->get('template_file')" class="mt-2" />
                        </div> 

                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload Assignment Files')" required /> 
                            <x-text-input id="files" class="block mt-1 w-full" type="file" name="files[]" multiple required autofocus autocomplete="files" />
                            <x-input-error :messages="$errors->get('files')" class="mt-2" />
                        </div> 

                        <div class="mt-4">
                            <div class="flex items-center gap-2">
                                <x-input-label for="shingles" :value="__('Shingles Size')" required />
                                <span class="text-xs text-gray-500">Used to split text into overlapping word groups for comparison. For example, 3-10 words per shingle. <br> Lower values make the checker more sensitive and may detect shorter matches, while higher values focus on longer, more significant similarities.</span>
                            </div>
                            <x-text-input id="shingles_size" class="block mt-1 w-full" type="number" :value="5" name="shingles_size" required autofocus autocomplete="shingles_size" />
                            <x-input-error :messages="$errors->get('shingles_size')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center gap-2">
                                <x-input-label for="threshold" :value="__('Similiarity Threshold (%)')" required />
                                <span class="text-xs text-gray-500">If the similarity between documents meets or exceeds this percentage, it will be flagged as plagiarism. For example, 50%.</span>
                            </div>
                            <x-text-input id="threshold" class="block mt-1 w-full" type="number" :value="50" name="threshold" required autofocus autocomplete="threshold" />
                            <x-input-error :messages="$errors->get('threshold')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4" style="background-color: #10b981 !important; border-color: #10b981 !important;">
                                {{ __('Check Plagiarism') }}
                            </x-primary-button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
