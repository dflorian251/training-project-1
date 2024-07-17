<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import List from '@/Components/List.vue';

let users = ref([]);

const fetchData = async () => {
    try {
        const response = await axios.get('/training-project-1/public/get-users');
        console.log(response.data);
        users.value = response.data;

        // const names = fetchedData.map(user => user.name);
        // const emails = fetchedData.map(user => user.email);
        // const roles = fetchedData.map(user => user.admin);
        // const users = fetchedData.map(({ name, email }) => ({ name, email }));
        console.log(users);
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
        <List :users="users"></List>
    </AuthenticatedLayout>
</template>
