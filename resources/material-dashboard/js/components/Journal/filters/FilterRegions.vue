<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
            <input
                @change="setAllRegions($event)"
                v-model="allRegionsSelected"
                id="allRegions"
                class="form-check-input m-0 me-1"
                type="checkbox"
            >
            <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allRegions">
                Выбрать все
            </label>
        </div>
        <div
            v-for="(region_, regionIndex) in allRegions"
            :key="regionIndex"
            class="form-check m-0 p-0 d-flex align-items-center mb-2">
            <input
                v-model="regions"
                :value="region_"
                :id="'id' + region_"
                class="form-check-input m-0 me-1"
                type="checkbox"
            >
            <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center" :for="'id' + region_">
                {{ region_ }}
            </label>
        </div>

<!--        <label-->
<!--            v-for="(region_, regionIndex) in allRegions"-->
<!--            :key="regionIndex"-->
<!--            class="form-check m-0 p-0 d-flex align-items-center mb-2 cursor-pointer">-->
<!--            <input-->
<!--                v-model="regions"-->
<!--                :value="region_"-->
<!--                :id="'id' + region_"-->
<!--                class="form-check-input m-0 me-1"-->
<!--                type="checkbox"-->
<!--                name="filterRegions"-->
<!--            >-->
<!--            <span class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center">-->
<!--                {{ region_ }}-->
<!--            </span>-->
<!--        </label>-->
        <button @click.prevent="setRegions()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterRegion",
    props: ['projectid'],
    data() {
        return {
            regions: [],
            allRegionsSelected: false,
            allRegions: null
        }
    },
    watch: {
        stateParamsRegion(regions) {
            if(regions) this.regions = regions
        },
        regions(arr) {
            if (arr.length === 0) this.allRegionsSelected = false
            if (arr.length === this.allRegions.length) {
                this.allRegionsSelected = true
            } else {
                this.allRegionsSelected = false
            }
        },
    },
    computed: {
        stateParamsRegions() {
            return this.$store.getters['filterParams/stateParamsRegions']
        }
    },
    methods: {
        setAllRegions() {
            if (this.allRegionsSelected) {
                this.regions = this.allRegions.map(region => {
                    return region
                })
            } else {
                this.regions = []
            }
        },
        async setRegions() {
            this.$store.commit('filterParams/SET_REGIONS', this.regions)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterRegions').on('hidden.bs.dropdown', () => {
            this.regions = this.stateParamsRegions
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'manual_region'  } })
            .then(response => {
                // console.log(response)
                this.allRegions = response.data
            })

        const regionsLS = localStorage.getItem('regions')
        if (regionsLS) {
            this.regions = JSON.parse(regionsLS)
            if (this.regions.length === this.allRegions.length) {
                this.allRegionsSelected = true
            } else {
                this.allRegionsSelected = false
            }
            this.$store.commit('filterParams/SET_REGIONS', this.regions)
        }
    }
}
</script>


<style scoped>

</style>
