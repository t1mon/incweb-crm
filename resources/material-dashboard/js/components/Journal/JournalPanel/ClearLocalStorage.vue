<template>
    <div>

        <button
            @click.prevent="clearLocalStorage"
            class="btn btn-outline-info m-0 mb-1 mb-md-0 me-md-2 py-1 px-3 d-flex align-items-center"
        >
            &nbsp;
            <i class="material-icons-round text-sm"><span class="material-symbols-outlined">restart_alt</span></i>
        </button>
    </div>
</template>

<script>
export default {
    name: "ClearLocalStorage",
    methods: {
        async clearLocalStorage() {
            localStorage.clear()
            if (localStorage.length === 0)
                window.location.reload()
            console.log(localStorage)
        }
    },

}
</script>

<style scoped>

</style>
