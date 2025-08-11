<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Driver Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome Message --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">
                    🚗 Welcome, {{ Auth::user()->name }}!
                </h3>
                <p>Here you can manage rides, view trip history, and check your earnings.</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                {{-- Total Rides --}}
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h4 class="text-sm text-gray-600">Total Rides</h4>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ Auth::user()->driverRides->count() }}
                    </p>
                </div>

                {{-- Wallet Balance --}}
                <div class="bg-green-50 p-6 rounded-lg shadow">
                    <h4 class="text-sm text-gray-600">Wallet Balance</h4>
                    <p class="text-2xl font-bold text-green-600">
                        ₱{{ number_format(Auth::user()->wallet->balance ?? 0, 2) }}
                    </p>
                </div>

                {{-- Total Earnings --}}
                <div class="bg-yellow-50 p-6 rounded-lg shadow">
                    <h4 class="text-sm text-gray-600">Total Earnings</h4>
                    <p class="text-2xl font-bold text-yellow-600">
                        ₱{{ number_format(Auth::user()->driverWalletTransactions->sum('amount'), 2) }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
