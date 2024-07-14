<script setup>
import Nav from "../Pages/Shared/Nav.vue";


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: false
    }
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <header class="bg-gray-800 p-4 ">
        <h1 class="text-white text-3xl">Hello, {{ name }}</h1>
    </header>

    <Nav/>

</template>
