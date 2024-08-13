<template>
    <div class="px-2 pt-2 d-flex flex-column">
        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllSource($event)"
                    v-model="allSourceSelected"
                    id="allSource"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allSource">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(source_, sourceIndex) in allSource"
                :key="sourceIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="source"
                    :value="source_"
                    :id="'id' + source_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + source_">
                    {{ source_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setSource()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterSource",
    props: ['projectid'],
    data() {
        return {
            source: [],
            allSourceSelected: false,
            allSource: null
        }
    },
    watch: {
        stateParamsSource(source) {
            if(source) this.cities = source
        },
        source(arr) {
            if (arr.length === 0) this.allSourceSelected = false
            if (arr.length === this.allSource.length) {
                this.allSourceSelected = true
            } else {
                this.allSourceSelected = false
            }
        },
    },
    computed: {
        stateParamsSource() {
            return this.$store.getters['filterParams/stateParamsSource']
        }
    },
    methods: {
        setAllSource() {
            if (this.allSourceSelected) {
                this.source = this.allSource.map(source => {
                    return source
                })
            } else {
                this.source = []
            }
        },
        async setSource() {
            this.$store.commit('filterParams/SET_SOURCE', this.source)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterSource').on('hidden.bs.dropdown', () => {
            this.source = this.stateParamsSource
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'source'  } })
            .then(response => {
                // console.log(response)
                this.allSource = response.data
            })

        const sourceLS = localStorage.getItem('source')
        if (sourceLS) {
            this.source = JSON.parse(sourceLS)
            if (this.source.length === this.allSource.length) {
                this.allSourceSelected = true
            } else {
                this.allSourceSelected = false
            }
            this.$store.commit('filterParams/SET_SOURCE', this.source)
        }
    }
}
</script>


<style scoped>

</style>
