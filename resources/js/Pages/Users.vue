<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, defineProps } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    admin: {
        type: String,
        required: true,
    }
});

let users = ref([]);

const fetchData = async () => {
    try {
        const response = await axios.get('/training-project-1/public/get-users');
        users.value = response.data;
    } catch (error) {
        console.error('There was an error retrieving the data:', error);
    }
};


onMounted(() => {
    fetchData();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4">
        <div class="bg-gray-100 shadow-md rounded-lg overflow-hidden">
                <PrimaryButton v-if="admin == 'Admin'" class="mb-3 bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50 active:bg-green-800">
                    <a href="/training-project-1/public/users/create-user" class="">
                        Create User
                    </a>
                </PrimaryButton>
                <div class="grid grid-cols-4 bg-gray-200 p-4 font-semibold">
                <div>Name</div>
                <div>Email</div>
                <div>Role</div>
                <div>Actions</div>
            </div>
            <div class="divide-y divide-gray-300">
                <div v-for="(user, index) in users" :key="index" class="grid grid-cols-4 p-4">
                    <div>{{ user.name }}</div>
                    <div>{{ user.email }}</div>
                    <div>{{ user.admin }}</div>
                    <div v-if="admin == 'Admin'">
                        <PrimaryButton class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50 active:bg-yellow-800">
                            <a :href="'/training-project-1/public/users/edit-user/' + String(user.id)">Modify</a>
                        </PrimaryButton>
                        <PrimaryButton class="ml-3 bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-50 active:bg-red-800">
                            <a :href="'/training-project-1/public/users/delete-user/' + String(user.id)">Delete</a>
                        </PrimaryButton>
                    </div>
                    <div v-else-if="name == user.name">
                        <PrimaryButton class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50 active:bg-yellow-800">
                            <a :href="'/training-project-1/public/users/edit-user/' + user.id">Modify</a>
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </AuthenticatedLayout>
</template>
