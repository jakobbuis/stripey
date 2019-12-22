<template>
    <div>
        <p class="text-gray-700 inline-flex items-center">
            <img src="/images/icons/calendar.svg" class="mr-1">
            <span>in meeting until {{ data.until }}</span>
        </p>
        <p class="text-gray-700 inline-flex items-center" v-if="data.location">
            <img src="/images/icons/location.svg" class="mr-1">
            <span class="truncate">
                {{ data.location }}
            </span>
        </p>
    </div>
</template>

<script>
export default {
    props: ['data'],
};
</script>
