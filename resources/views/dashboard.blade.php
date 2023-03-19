<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('シフト管理画面') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @php
                $username = auth()->user()->name;
                $userid = auth()->user()->id;
                $currentTeamId = auth()->user()->current_team_id;
                @endphp
                @vite(['resources/css/app.css', 'resources/js/calendar.js'])
                <script>
                    var username = "{{ $username }}";
                    var userid = "{{ $userid }}";
                    var currentTeamId = "{{ $currentTeamId }}";
                </script>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</x-app-layout>