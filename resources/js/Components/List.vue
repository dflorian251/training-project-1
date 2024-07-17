<script setup>
import { defineProps, onMounted } from 'vue';

const props = defineProps({
  users: {
    type: Array,
    required: true,
    default: () => [],
  },
});

onMounted(() => {
  if (Array.isArray(props.users)) {
    console.log('The users prop is an array.');
  } else {
    console.error('The users prop is not an array.');
  }
});

</script>

<template>
  <div class="container mx-auto p-4">
    <div class="bg-gray-100 shadow-md rounded-lg overflow-hidden">
      <div class="grid grid-cols-3 bg-gray-200 p-4 font-semibold">
        <div>Name</div>
        <div>Email</div>
        <div>Role</div>
      </div>
      <div class="divide-y divide-gray-300">
        <div v-for="(user, index) in users" :key="index" class="grid grid-cols-3 p-4">
          <div>{{ user.name }}</div>
          <div>{{ user.email }}</div>
          <div>{{ user.admin }}</div>
        </div>
      </div>
    </div>
  </div>
</template>
