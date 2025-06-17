<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <!-- Client Details -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Client Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="client_name" :value="__('Client Name')" />
                                    <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('client_name')" />
                                </div>

                                <div>
                                    <x-input-label for="client_email" :value="__('Client Email')" />
                                    <x-text-input id="client_email" name="client_email" type="email" class="mt-1 block w-full" :value="old('client_email')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('client_email')" />
                                </div>

                                <div>
                                    <x-input-label for="client_phone" :value="__('Client Phone')" />
                                    <x-text-input id="client_phone" name="client_phone" type="text" class="mt-1 block w-full" :value="old('client_phone')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('client_phone')" />
                                </div>
                            </div>
                        </div>

                        <!-- Service Selection -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Service Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="service_id" :value="__('Service')" />
                                    <select id="service_id" name="service_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Select a service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration }}" data-vendor-id="{{ $service->vendor->id ?? '' }}">
                                                {{ $service->name }} - ${{ number_format($service->price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('service_id')" />
                                </div>

                                <div>
                                    <x-input-label for="staff_id" :value="__('Staff Member')" />
                                    <select id="staff_id" name="staff_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($staff as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach

                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('staff_id')" />
                                </div>
                            </div>
                        </div>

                        <!-- Date and Time -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="booking_date" :value="__('Date')" />
                                    <x-text-input id="booking_date" name="booking_date" type="date" class="mt-1 block w-full" :value="old('booking_date')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('booking_date')" />
                                </div>

                                <div>
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                                </div>

                                <div>
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div>
                                <x-input-label for="notes" :value="__('Notes')" />
                                <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notes') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Create Booking') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('service_id');
            const staffSelect = document.getElementById('staff_id');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            const allStaff = @json($staff);

            function filterStaffMembers(selectedVendorId) {
                staffSelect.innerHTML = '<option value="">Select a staff member</option>'; // Clear current options
                const filteredStaff = allStaff.filter(staff => staff.vendor_id == selectedVendorId);

                filteredStaff.forEach(staff => {
                    const option = document.createElement('option');
                    option.value = staff.id;
                    option.textContent = staff.name;
                    staffSelect.appendChild(option);
                });
            }

            serviceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const duration = selectedOption.dataset.duration;
                const vendorId = selectedOption.dataset.vendorId;
                
                filterStaffMembers(vendorId);

                if (startTimeInput.value) {
                    const startTime = new Date(`2000-01-01T${startTimeInput.value}`);
                    const endTime = new Date(startTime.getTime() + duration * 60000);
                    endTimeInput.value = endTime.toTimeString().slice(0, 5);
                }
            });

            startTimeInput.addEventListener('change', function() {
                if (serviceSelect.value) {
                    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                    const duration = selectedOption.dataset.duration;
                    
                    const startTime = new Date(`2000-01-01T${this.value}`);
                    const endTime = new Date(startTime.getTime() + duration * 60000);
                    endTimeInput.value = endTime.toTimeString().slice(0, 5);
                }
            });

            // Initial filtering if a service is already selected (e.g., on form re-population after validation error)
            if (serviceSelect.value) {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const vendorId = selectedOption.dataset.vendorId;
                filterStaffMembers(vendorId);
            }
        });
    </script>
    @endpush
</x-app-layout> 