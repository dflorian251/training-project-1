<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, defineProps } from 'vue';
import axios from 'axios';
import List from '@/Components/List.vue';


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

        <List :users="users" :name="name" :admin="admin">
        </List>
    </AuthenticatedLayout>
</template>
