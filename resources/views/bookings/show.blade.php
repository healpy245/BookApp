<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Details') }}
            </h2>
            <div class="flex space-x-4">
                @if($booking->status === 'pending')
                    <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                        {{ __('Edit Booking') }}
                    </a>
                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to cancel this booking?')">
                            {{ __('Cancel Booking') }}
                        </button>
                    </form>
                @endif
                <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Back to Bookings') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Client Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->client_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->client_email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->client_phone }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Service Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Service Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Service</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->service->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Staff Member</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->staff->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($booking->total_price, 2) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Schedule Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_date->format('F j, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->start_time }} - {{ $booking->end_time }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->notes ?: 'No additional notes' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->created_at->format('F j, Y g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 