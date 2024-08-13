<template>
    <div class="px-2 pt-2 d-flex flex-column">
        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div
                v-for="(referrer_, referrerIndex) in allReferrer"
                :key="referrerIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="referrer"
                    :value="referrer_"
                    :id="'id' + referrer_"
                    class="form-check-input m-0 me-1"
                    type="radio"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + referrer_">
                    {{ referrer_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setReferrer()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterReferrer",
    props: ['projectid'],
    data() {
        return {
            referrer: '',
            allReferrer: null
        }
    },
    watch: {
        stateParamsReferrer(referrer) {
            this.referrer = referrer
        }
    },
    computed: {
        stateParamsReferrer() {
            return this.$store.getters['filterParams/stateParamsReferrer']
        }
    },
    methods: {
        async setReferrer() {
            this.$store.commit('filterParams/SET_REFERRER', this.referrer)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterReferrer').on('hidden.bs.dropdown', () => {
            this.referrer = this.stateParamsReferrer
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'referrer'  } })
            .then(response => {
                // console.log(response)
                this.allReferrer = response.data
            })

        const referrerLS = localStorage.getItem('referrer')
        if (referrerLS) {
            this.referrer = referrerLS
            this.$store.commit('filterParams/SET_REFERRER', this.referrer)
        }
    }
}
</script>


<style scoped>

</style>
