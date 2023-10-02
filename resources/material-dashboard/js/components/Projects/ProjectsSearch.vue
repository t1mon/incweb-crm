<template>
<div class="input-group w-auto project-search">
    <input
      id="form-control"
      v-model="filter"
      :disabled="stateIsLoading"
      type="text"
      class="form-control border rounded-0 p-1 px-2 text-light"
      placeholder="Нати проект"
    >
</div>
</template>

<script>
export default {
  name: 'ProjectsFilter',
  data: () => ({
    filter: ''
  }),
  computed: {
    stateIsLoading () {
      return this.$store.getters.stateIsLoading
    }

  },
  watch: {
    filter () {
      window.history.pushState(null, document.title, `${window.location.pathname}?filter=${this.filter}`)
      this.$store.commit('updateMessage', this.filter)
      this.$store.dispatch('filterProjects')
    },
    stateIsLoading () {
      const windowData = Object.fromEntries(
        new URL(window.location).searchParams.entries()
      )
      if (windowData.filter) {
        this.filter = windowData.filter
      }
    }
  }
}
</script>

<style scoped>
@media screen and (max-width: 575px) {
    .filter {
        width: 150px;
    }
    .project-search {
        order: 3;
        width: 100% !important;
    }
}
</style>
