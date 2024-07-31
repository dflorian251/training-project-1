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
        label: 'People Attended',
        data: [] // events.people_attended
    }]
};

const options = {
    responsive: true,
    aspectRatio: 2 | 4
};

let loaded = ref(false);

const baseUrl = window.location.origin;

const processData = (people_attended, dates) => {
    dates.forEach((date, index, arr)=> {
        //The array is on ascending order
        //So If we have duplicate dates, then they are gonna be next ot each other
        //Thus it makes sanse to check only the next element
        if (date === arr[index + 1]) {
            //Merge the date's stats
            people_attended[index] = people_attended[index] + people_attended[index + 1];
            people_attended.splice(index + 1, 1);
            dates.splice(index + 1, 1);
        }
    });
}

const fetchData = async () => {
    try {
        // const response = await axios.get(`${baseUrl}/get-events`);
        const response = await axios.get('/training-project-1/public/get-events');
        console.log('Data submitted successfully:', typeof(response.data));
        const fetchedData = response.data;

        data.labels = fetchedData.map(event => event.date);
        data.datasets[0].data = fetchedData.map(event => event.people_attended);

        processData(data.datasets[0].data, data.labels);

        loaded.value = true;
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

