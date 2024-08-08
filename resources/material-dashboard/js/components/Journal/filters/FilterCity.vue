<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div style="overflow: auto; max-height: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllCities($event)"
                    v-model="allCitiesSelected"
                    id="allCities"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allCities">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(city_, cityIndex) in allCities"
                :key="cityIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="cities"
                    :value="city_"
                    :id="'id' + city_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center" :for="'id' + city_">
                    {{ city_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setCities()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterCity",
    props: ['projectid'],
    data() {
        return {
            cities: [],
            allCitiesSelected: false,
            allCities: null
        }
    },
    watch: {
        stateParamsCities(cities) {
            if(cities) this.cities = cities
        },
        cities(arr) {
            if (arr.length === 0) this.allCitiesSelected = false
            if (arr.length === this.allCities.length) {
                this.allCitiesSelected = true
            } else {
                this.allCitiesSelected = false
            }
        },
    },
    computed: {
        stateParamsCities() {
            return this.$store.getters['filterParams/stateParamsCities']
        }
    },
    methods: {
        setAllCities() {
            if (this.allCitiesSelected) {
                this.cities = this.allCities.map(city => {
                    return city
                })
            } else {
                this.cities = []
            }
        },
        async setCities() {
            this.$store.commit('filterParams/SET_CITIES', this.cities)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterCity').on('hidden.bs.dropdown', () => {
            this.cities = this.stateParamsCities
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'city'  } })
            .then(response => {
                // console.log(response)
                this.allCities = response.data
            })

        const citiesLS = localStorage.getItem('cities')
        if (citiesLS) {
            this.cities = JSON.parse(citiesLS)
            if (this.cities.length === this.allCities.length) {
                this.allCitiesSelected = true
            } else {
                this.allCitiesSelected = false
            }
            this.$store.commit('filterParams/SET_CITIES', this.cities)
        }
    }
}
</script>


<style scoped>

</style>
