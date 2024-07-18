<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, defineProps } from 'vue';


const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    admin: {
        type: String,
        required: true,
    }
});

const form = ref({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: '',
});

let user = ref([]);

const fetchData = async () => {
    try {
        const response = await axios.get(`/training-project-1/public/get-user/${props.id}`);
        user.value = response.data;
        user = user.value;
        console.log(user);
    } catch (error) {
        console.error('There was an error retrieving the data:', error);
    }
};

const errors = ref({});

const submit = async () => {
    try {
        const response = await axios.post(`/training-project-1/public/users/store-edited-user/${props.id}`, form.value);
        console.log('User updated successfully', response.data);
        form.value = {
            name: '',
            email: '',
            role: '',
            password: '',
            password_confirmation: '',
        };
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // Handle validation errors
            errors.value = error.response.data.errors;
        } else {
            console.error('An error occurred:', error);
        }
    }
};

onMounted(() => {
    fetchData();
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit User" />
        <div class="flex justify-center items-center min-h-screen bg-gray-100">

            <form @submit.prevent="submit" class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Edit User</h1>
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autofocus
                        autocomplete="name"
                        :placeholder="user.name"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>

                <div class="mt-4" v-if="admin == 'Admin'">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        autocomplete="username"
                        :placeholder="user.email"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                </div>

                <div class="mt-4" v-if="admin == 'Admin'">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 white:text-black">Select a role</label>
                    <!-- DOES NOT WORK THO / MUST RESEARCH HOW TO IMPLEMENT SELECTED OPTION -->
                    <select id="role" v-if="user.admin == 'Admin'"  v-model="form.role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 white:border-gray-600 dark:placeholder-gray-400 white:text dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="admin">Admin</option>
                        <option value="public">Public</option>
                    </select>

                    <select id="role" v-else  v-model="form.role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 white:border-gray-600 dark:placeholder-gray-400 white:text dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="admin">Admin</option>
                        <option selected value="public">Public</option>
                    </select>
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        autocomplete="new-password"
                        :placeholder="user.password"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                        :placeholder="user.password"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.password_confirmation" /> -->
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Edit user
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
