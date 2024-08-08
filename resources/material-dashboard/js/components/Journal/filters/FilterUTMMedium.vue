<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllUtmMedium($event)"
                    v-model="allUtmMediumSelected"
                    id="allUtmMedium"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allUtmMedium">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(utm_medium_, utm_mediumIndex) in allUtmMedium"
                :key="utm_mediumIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="utm_medium"
                    :value="utm_medium_"
                    :id="'id' + utm_medium_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + utm_medium_">
                    {{ utm_medium_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setUtmMedium()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterUTMMedium",
    props: ['projectid'],
    data() {
        return {
            utm_medium: [],
            allUtmMediumSelected: false,
            allUtmMedium: null
        }
    },
    watch: {
        stateParamsUtmMedium(utm_medium) {
            if(utm_medium) this.utm_medium = utm_medium
        },
        utm_medium(arr) {
            if (arr.length === 0) this.allUtmMediumSelected = false
            if (arr.length === this.allUtmMedium.length) {
                this.allUtmMediumSelected = true
            } else {
                this.allUtmMediumSelected = false
            }
        },
    },
    computed: {
        stateParamsUtmMedium() {
            return this.$store.getters['filterParams/stateParamsUtmMedium']
        }
    },
    methods: {
        setAllUtmMedium() {
            if (this.allUtmMediumSelected) {
                this.utm_medium = this.allUtmMedium.map(utm_medium => {
                    return utm_medium
                })
            } else {
                this.utm_medium = []
            }
        },
        async setUtmMedium() {
            this.$store.commit('filterParams/SET_UTM_MEDIUM', this.utm_medium)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterUTMMedium').on('hidden.bs.dropdown', () => {
            this.utm_medium = this.stateParamsUtmMedium
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'utm_medium' } })
            .then(response => {
                // console.log(response)
                this.allUtmMedium = response.data
            })

        const utm_mediumLS = localStorage.getItem('utm_medium')
        if (utm_mediumLS) {
            this.utm_medium = JSON.parse(utm_mediumLS)
            if (this.utm_medium.length === this.allUtmMedium.length) {
                this.allUtmMediumSelected = true
            } else {
                this.allUtmMediumSelected = false
            }
            this.$store.commit('filterParams/SET_UTM_MEDIUM', this.utm_medium)
        }
    }
}
</script>


<style scoped>

</style>
