<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const data = {
    labels: [], // events.date
    datasets: [{
        label: 'DATES',
        data: [] // events.people_attended
    }]
};

const options = {
    responsive: true,
    aspectRatio: 2 | 3
};

let loaded = false;

const fetchData = async () => {
    try {
        const response = await axios.get('/training-project-1/public/get-data');
        console.log('Data submitted successfully:', typeof(response.data));
        const fetchedData = response.data;

        data.labels = fetchedData.map(event => event.date);
        data.datasets[0].data = fetchedData.map(event => event.people_attended);
        // data.labels = JSON.stringify(data.labels);
        // data.datasets[0].data = JSON.stringify(data.datasets[0].data);

        console.log(`Labels: ${data.labels}`);
        console.log(`Data: ${data.datasets[0].data}`);

        loaded = true;
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
        <Bar :data="data" :options="options" v-if="loaded"/>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: 'App',
}
</script>

