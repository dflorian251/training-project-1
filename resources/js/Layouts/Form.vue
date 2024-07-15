<script setup>
import PrimaryButton from "../Components/PrimaryButton.vue";
import Checkbox from "../Components/Checkbox.vue";
import InputLabel from "../Components/InputLabel.vue";
import { ref } from 'vue';
import axios from 'axios';
import {createRouter} from 'vue-router';


const formData = ref({
  name: '',
  publicity: '',
  date: '',
  people_attended: '',
});

const submitForm = async () => {
  try {
    const response = await axios.post('/training-project-1/public/submit-form', formData.value).then(function (response) {
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
        <input type="text" id="name" name="name" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="formData.name">
        </div>


        <div>
        <InputLabel for="publicity" class="font-light text-gray-500" value="Public" />
        <Checkbox
            id="publicity_checkbox"
            class="mt-1 block w-full"
            name="publicity_checkbox"
            required
            v-model="formData.publicity"
        />
        </div>


        <div>
        <label for="date" class="block text-gray-700">Event Date</label>
        <input type="date" id="date" name="date" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="formData.date">
        </div>

        <div>
        <label for="people_attended" class="block text-gray-700">People Attended</label>
        <input type="number" id="people_attended" name="people_attended" required class="w-full p-2 border border-gray-300 rounded mt-1" v-model="formData.people_attended">
        </div>

        <PrimaryButton class="ms-4">
        Create Event
        </PrimaryButton>
    </form>
  </div>
</template>
