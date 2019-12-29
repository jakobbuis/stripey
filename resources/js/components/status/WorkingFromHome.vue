<template>
    <div>
        <p class="text-gray-700 inline-flex items-center">
            <img src="/images/icons/home.svg" class="mr-1" alt="">
            <span>working from home</span>
        </p>
        <p class="text-gray-700 inline-flex items-center">
            <img src="/images/icons/calendar.svg" class="mr-1" alt="">
            <span class="truncate">
                back in the office {{ data.until }}
            </span>
        </p>
    </div>
</template>

<script>
export default {
    props: ['data'],
};
</script>
