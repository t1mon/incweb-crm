<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllUtmSource($event)"
                    v-model="allUtmSourceSelected"
                    id="allUtmSource"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allUtmSource">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(utm_source_, utm_sourceIndex) in allUtmSource"
                :key="utm_sourceIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="utm_source"
                    :value="utm_source_"
                    :id="'id' + utm_source_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + utm_source_">
                    {{ utm_source_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setUtmSource()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterUTMSource",
    props: ['projectid'],
    data() {
        return {
            utm_source: [],
            allUtmSourceSelected: false,
            allUtmSource: null
        }
    },
    watch: {
        stateParamsUtmSource(utm_source) {
            if(utm_source) this.utm_source = utm_source
        },
        utm_source(arr) {
            if (arr.length === 0) this.allUtmSourceSelected = false
            if (arr.length === this.allUtmSource.length) {
                this.allUtmSourceSelected = true
            } else {
                this.allUtmSourceSelected = false
            }
        },
    },
    computed: {
        stateParamsUtmSource() {
            return this.$store.getters['filterParams/stateParamsUtmSource']
        }
    },
    methods: {
        setAllUtmSource() {
            if (this.allUtmSourceSelected) {
                this.utm_source = this.allUtmSource.map(utm_source => {
                    return utm_source
                })
            } else {
                this.utm_source = []
            }
        },
        async setUtmSource() {
            this.$store.commit('filterParams/SET_UTM_SOURCE', this.utm_source)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterUTMSource').on('hidden.bs.dropdown', () => {
            this.utm_source = this.stateParamsUtmSource
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'utm_source' } })
            .then(response => {
                // console.log(response)
                this.allUtmSource = response.data
            })

        const utm_sourceLS = localStorage.getItem('utm_source')
        if (utm_sourceLS) {
            this.utm_source = JSON.parse(utm_sourceLS)
            if (this.utm_source.length === this.allUtmSource.length) {
                this.allUtmSourceSelected = true
            } else {
                this.allUtmSourceSelected = false
            }
            this.$store.commit('filterParams/SET_UTM_SOURCE', this.utm_source)
        }
    }
}
</script>


<style scoped>

</style>
