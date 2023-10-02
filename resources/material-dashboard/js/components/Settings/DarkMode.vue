<template>
    <div>
        <i class="material-icons-round text-light">brightness_4</i>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input ms-auto mt-0" type="checkbox" id="dark-version" @click="darkModeLS">
        </div>
    </div>
</template>

<script>

export default {
  name: 'FixedPlugin',
  methods: {
    darkModeLS () {
      if (localStorage.getItem('darkVersion') === 'true') {
        localStorage.setItem('darkVersion', 'false')
      } else {
        localStorage.setItem('darkVersion', 'true')
      }
    }
  }
}
</script>

<style scoped>

</style>
