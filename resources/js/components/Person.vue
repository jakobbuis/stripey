<template>
    <div class="m-4 border p-2 rounded border-gray-400">
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
