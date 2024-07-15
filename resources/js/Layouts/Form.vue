<script setup>
import PrimaryButton from "../Components/PrimaryButton.vue";
import Checkbox from "../Components/Checkbox.vue";
import InputLabel from "../Components/InputLabel.vue";
import { ref } from 'vue';
import axios from 'axios';
import {createRouter} from 'vue-router';


const form = ref({
  name: '',
  publicity: '',
  date: '',
  people_attended: '',
});

const submitForm = async () => {
  try {
    const response = await axios.post('/training-project-1/public/submit-form', form.value).then(function (response) {
        window.location = response.data.redirect;
    });
    console.log('Data submitted successfully:', response.data);
    // errors.value = {}; // Clear errors on successful submission
    if (response.data.redirect_url) {
        // router.push(response.data.redirect_url); // Redirect to the URL provided by the server
        this.$router.push('/training-project-1/public/');
        console.log('Redirected...');
    }
  } catch (error) {
    console.error('There was an error submitting the form:', error);
  }
};
</script>

<template>
  <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
    <h1 class="text-3xl text-white bg-gray-800 p-4 rounded mb-6 text-center">Create Event</h1>
    <form @submit.prevent="submitForm" method="POST" class="space-y-4">
        <!-- CSRF Token for Laravel -->
        <input type="hidden" name="_token" :value="csrf_token">

        <div>
        <label for="name" class="block text-gray-700">Event Name</label>
        <input type="text" id="name" name="name" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="form.name">
        </div>

        <div>
            <InputLabel for="event_visibility" value="Event Visibility" />
            <select id="event_visibility" v-model="form.publicity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 white:border-gray-600 dark:placeholder-gray-400 white:text dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>The event was...</option>
                <option value="public">Public</option>
                <option value="private">Private (not public)</option>
            </select>
        </div>

        <div>
        <label for="date" class="block text-gray-700">Event Date</label>
        <input type="date" id="date" name="date" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="form.date">
        </div>

        <div>
        <label for="people_attended" class="block text-gray-700">People Attended</label>
        <input type="number" id="people_attended" name="people_attended" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="form.people_attended">
        </div>

        <PrimaryButton class="ms-4">
        Create Event
        </PrimaryButton>
    </form>
  </div>
</template>
