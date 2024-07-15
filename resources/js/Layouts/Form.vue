<script setup>
// import ApplicationLogo from '@/Components/ApplicationLogo.vue';
// import { Link } from '@inertiajs/vue3';
import PrimaryButton from "../Components/PrimaryButton.vue";
import Checkbox from "../Components/Checkbox.vue";
import InputLabel from "../Components/InputLabel.vue";
</script>

<template>

    <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
        <h1 class="text-3xl text-white bg-gray-800 p-4 rounded mb-6 text-center">Create Event</h1>
        <form action="/events" method="POST" class="space-y-4">
            <!-- CSRF Token for Laravel -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div>
                <label for="name" class="block text-gray-700">Event Name</label>
                <input type="text" id="name" name="name" required class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>


            <div>
                <InputLabel for="role"  class="font-light text-gray-500" value="Public" />
                <Checkbox
                    class="mt-1 block w-full"
                    name="role-checkbox"
                    required
                />
            </div>

            <div>
                <label for="date" class="block text-gray-700">Event Date</label>
                <input type="date" id="date" name="date" required class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>

            <div>
                <label for="people_attended" class="block text-gray-700">People Attended</label>
                <input type="number" id="people_attended" name="people_attended" required class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>

            <PrimaryButton class="ms-4">
                Create Event
            </PrimaryButton>
        </form>
    </div>

</template>
