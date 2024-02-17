<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllUtmTerm($event)"
                    v-model="allUtmTermSelected"
                    id="allUtmTerm"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allUtmTerm">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(utm_term_, utm_termIndex) in allUtmTerm"
                :key="utm_termIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="utm_term"
                    :value="utm_term_"
                    :id="'id' + utm_term_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + utm_term_">
                    {{ utm_term_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setUtmTerm()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterUTMTerm",
    props: ['projectid'],
    data() {
        return {
            utm_term: [],
            allUtmTermSelected: false,
            allUtmTerm: null
        }
    },
    watch: {
        stateParamsUtmTerm(utm_term) {
            if(utm_term) this.utm_term = utm_term
        },
        utm_term(arr) {
            if (arr.length === 0) this.allUtmTermSelected = false
            if (arr.length === this.allUtmTerm.length) {
                this.allUtmTermSelected = true
            } else {
                this.allUtmTermSelected = false
            }
        },
    },
    computed: {
        stateParamsUtmTerm() {
            return this.$store.getters['filterParams/stateParamsUtmTerm']
        }
    },
    methods: {
        setAllUtmTerm() {
            if (this.allUtmTermSelected) {
                this.utm_term = this.allUtmTerm.map(utm_term => {
                    return utm_term
                })
            } else {
                this.utm_term = []
            }
        },
        async setUtmTerm() {
            this.$store.commit('filterParams/SET_UTM_TERM', this.utm_term)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterUTMTerm').on('hidden.bs.dropdown', () => {
            this.utm_term = this.stateParamsUtmTerm
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'utm_term' } })
            .then(response => {
                this.allUtmTerm = response.data
            })

        const utm_termLS = localStorage.getItem('utm_term')
        if (utm_termLS) {
            this.utm_term = JSON.parse(utm_termLS)
            if (this.utm_term.length === this.allUtmTerm.length) {
                this.allUtmTermSelected = true
            } else {
                this.allUtmTermSelected = false
            }
            this.$store.commit('filterParams/SET_UTM_TERM', this.utm_term)
        }
    }
}
</script>


<style scoped>

</style>
