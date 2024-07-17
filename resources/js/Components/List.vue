<script setup>
import { defineProps, onMounted, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
    default: () => [],
  },
  name: {
    type: String,
    required: true,
  },
  admin: {
    type: String,
    required: true,
  }
});

let username =ref([]);

onMounted(() => {
  if (Array.isArray(props.users)) {
    console.log('The users prop is an array.');
    // console.log();
  } else {
    console.error('The users prop is not an array.');
  }
});

</script>

<template>
    <div class="container mx-auto p-4">
    <div class="bg-gray-100 shadow-md rounded-lg overflow-hidden">
            <PrimaryButton v-if="admin == 'Admin'" class="mb-3 bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-opacity-50 active:bg-green-800">Create User</PrimaryButton>
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
                    <PrimaryButton class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50 active:bg-yellow-800">Modify</PrimaryButton>
                    <PrimaryButton class="ml-3 bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-50 active:bg-red-800">Delete</PrimaryButton>
                </div>
                <div v-else-if="name == user.name">
                    <PrimaryButton class="bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-50 active:bg-yellow-800">Modify</PrimaryButton>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
