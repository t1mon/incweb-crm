<template>
    <div v-if="stateLoader" class="loader-wrap">
        <div class="loader"></div>
    </div>
</template>

<script>
export default {
    name: "Spinner",
    computed: {
        stateLoader() {
            return this.$store.getters['loader/stateLoader']
        }
    }
}
</script>

<style scoped>

.loader-wrap {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.loader {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: inline-block;
    position: relative;
    border: 10px solid;
    box-sizing: border-box;
    animation: animloader 1s linear infinite alternate;
}
@keyframes animloader {
    0% {
        border-color: white rgba(255, 255, 255, 0) rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
    }
    33% {
        border-color: white white rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
    }
    66% {
        border-color: white white white rgba(255, 255, 255, 0);
    }
    100% {
        border-color: white white white white;
    }
}
</style>
