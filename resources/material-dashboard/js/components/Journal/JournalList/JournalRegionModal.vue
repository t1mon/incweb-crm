<template>
    <div class="modal fade" id="journalRegion" tabindex="-1" role="dialog" aria-labelledby="journalRegionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="journalRegionLabel">Регион:</h5>
                    <button ref="closeRegion" type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <input
                            v-model="region"
                            placeholder="Введите регион"
                            type="text"
                            class="form-control text-white"
                        >
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button
                        @click="addDeleteRegion"
                        type="button"
                        class="btn bg-success w-50 rounded-0 m-0 text-white">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "JournalRegionModal",
    data() {
        return {
            region: ''
        }
    },
    computed: {
        stateLeadId() {
            return this.$store.getters['journalRegion/stateLeadId']
        }
    },
    methods: {
        async addDeleteRegion() {
            this.$store.commit('loader/LOADER_TRUE')
            if (!this.region) {
                await axios.delete('/api/v2/lead/manual_region/clear', {
                    data: {
                        lead_id: this.stateLeadId
                    }
                }).then(response => {
                    this.$store.commit('journalRegion/SET_MANUAL_REGION', '')
                    this.$refs.closeRegion.click()
                    this.$store.commit('loader/LOADER_FALSE')
                    this.$store.dispatch('getToast', {
                        msg: 'Регион удалён!',
                        settingsObj: {
                            type: 'success',
                            position: 'bottom-right',
                            timeout: 2000,
                            showIcon: true
                        }
                    })
                }).catch(error => {
                    this.$store.commit('loader/LOADER_FALSE')
                    console.log(error)
                })
            } else {
                await axios.post('/api/v2/lead/manual_region/add', {
                    lead_id: this.stateLeadId,
                    region: this.region
                }).then(response => {
                    this.$store.commit('journalRegion/SET_MANUAL_REGION', this.region)
                    this.$refs.closeRegion.click()
                    this.$store.commit('loader/LOADER_FALSE')
                    this.$store.dispatch('getToast', {
                        msg: 'Регион обновлён!',
                        settingsObj: {
                            type: 'success',
                            position: 'bottom-right',
                            timeout: 2000,
                            showIcon: true
                        }
                    })
                }).catch(error => {
                    this.$store.commit('loader/LOADER_FALSE')
                    console.log(error)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
