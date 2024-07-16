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

const data = ref({
    labels: [], // events.date
    datasets: [{
        data: [] // events.people_attended
    }]
});

const options = {
    responsive: true,
    aspectRatio: 2 | 3
};

const fetchData = async () => {
    try {
        const response = await axios.get('/training-project-1/public/get-data');
        console.log('Data submitted successfully:', response.data);
        const fetchedData = response.data;

        data.value.labels = fetchedData.map(event => event.date);
        data.value.datasets[0].data = fetchedData.map(event => event.people_attended);
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
        <Bar :data="data" :options="options" />
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: 'App',
    components: {
        Bar
    },
    data() {
        return {
            data, // use the reactive data object
            options
        }
    }
}
</script>
