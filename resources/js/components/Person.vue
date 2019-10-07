<template>
    <div class="m-4 border p-2 rounded border-gray-400 flex">
        <img :src="person.avatar" width="32" height="32" class="rounded-full mr-2">
        <h2 class="font-bold mb-1">
            {{ person.name }}
        </h2>
        <p class="italic">
            {{ person.location }}
        </p>
    </div>
</template>

<script>
export default {
    props: ['person'],
};
</script>
