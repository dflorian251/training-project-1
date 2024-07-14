<script setup>
import { Link } from '@inertiajs/vue3';


</script>

<template>
    <nav class="bg-gray-800 p-4">
        <ul class="flex space-x-4">
            <li><Link :href="route('home')" class="text-white hover:text-gray-400">Home</Link></li>
            <li><Link :href="route('data')" class="text-white hover:text-gray-400">Data</Link></li>
            <li><Link :href="route('charts')" class="text-white hover:text-gray-400">Charts</Link></li>
            <li><Link :href="route('users')" class="text-white hover:text-gray-400">Users</Link></li>
            <li><Link :href="route('login')" class="text-white hover:text-gray-400">Login</Link></li>
            <li><Link :href="route('register')" class="text-white hover:text-gray-400">Register</Link></li>
        </ul>
    </nav>
</template>
