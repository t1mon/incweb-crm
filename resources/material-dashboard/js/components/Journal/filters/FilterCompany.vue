<template>
    <div class="px-2 pt-2 d-flex flex-column">
        <label
            v-for="(company_, companyIndex) in allCompanies"
            :key="companyIndex"
            class="form-check m-0 p-0 d-flex align-items-center mb-2 cursor-pointer">
            <input
                v-model="company"
                :value="company_"
                :id="'id' + company_"
                class="form-check-input m-0 me-1"
                type="radio"
                name="filterRadio"
            >
            <span class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center">
                {{ company_ }}
            </span>
        </label>
        <button @click.prevent="setCompany()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterCompany",
    props: ['projectid'],
    data() {
        return {
            company: '',
            allCompanies: null
        }
    },
    watch: {
        stateParamsCompany(company) {
            if(company) this.company = company
        }
    },
    computed: {
        stateParamsCompany() {
            return this.$store.getters['filterParams/stateParamsCompany']
        }
    },
    methods: {
        async setCompany() {
            this.$store.commit('filterParams/SET_COMPANY', this.company)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
        const companyLS = localStorage.getItem('company')
        if (companyLS) {
            this.company = companyLS
            this.$store.commit('filterParams/SET_COMPANY', this.company)
        }
    },
    mounted() {
        $('#filterCompany').on('hidden.bs.dropdown', () => {
            this.company = this.stateParamsCompany
        })
        axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'company'  } })
            .then(response => {
                // console.log(response)
                this.allCompanies = response.data
            })
    }
}
</script>


<style scoped>

</style>
