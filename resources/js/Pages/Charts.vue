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

const fetchData = async () => {
    try {
        const response = await axios.get('/training-project-1/public/get-events');
        console.log('Data submitted successfully:', typeof(response.data));
        const fetchedData = response.data;

        data.labels = fetchedData.map(event => event.date);
        data.datasets[0].data = fetchedData.map(event => event.people_attended);

        let labels = [];
        let data_labels =[...data.labels];
        // console.log(`Arrays: ${data.labels}\n${data.datasets[0].data}`);
        let data_people = [...data.datasets[0].data];

        response.data.forEach( (data, index) => {

            if (labels.includes(data.date)) {
                // sum the people attended values
                console.log(`Iteration through the array n.${index}`);
                let first_occurance = data_labels.indexOf(data.date) // find the index
                // console.log(`DATA: ${data.people_attended}`);
                console.log(`We have a second instance of ${data.date} in the labels array. The first occurance of this date in the labels array is on position: ${first_occurance}`);
                console.log(`Add ${data_people[first_occurance]} + ${data_people[index]}.\n At location: ${first_occurance}`);
                data_people[first_occurance] = data_people[first_occurance] + data_people[index];     // ?????
                console.log(`Sceenshot of data_people: ${data_people}`);
                console.log(`Addition result's in: ${data_people[first_occurance]} saved in location ${first_occurance}`);
            } else {
                // append the date and its corresponding people_attended value
                labels.push(data.date);
                // data_people.push(data_people[index]);
            }
        });

        data.labels = [...labels];
        data.datasets[0].data = [...data_people];

        // console.log(data.labels, data.datasets[0].data);
        console.log(labels, data_people);



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

