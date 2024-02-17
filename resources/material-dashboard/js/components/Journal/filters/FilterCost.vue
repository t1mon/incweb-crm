<script>
export default {
    name: "FilterCost",
    data() {
        return {
            cost_from: '',
            cost_to: ''
        }
    },
    watch: {
        stateParamsCostFrom(cost_from) {
            this.cost_from = cost_from
        },
        stateParamsCostTo(cost_to) {
            this.cost_to = cost_to
        },
    },
    computed: {
        stateParamsCostFrom() {
            return this.$store.getters['filterParams/stateParamsCostFrom']
        },
        stateParamsCostTo() {
            return this.$store.getters['filterParams/stateParamsCostTo']
        }
    },
    methods: {
        prettify(field) {
            this[field] = this[field].replace(/\D/g, '')
            this[field] = this[field].replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g, "$1" + ' ');
        },
        async setCost() {
            const cost = {
                from: this.cost_from ? +this.cost_from.toString().replace(/\D/g, '') : '',
                to: this.cost_to ? +this.cost_to.toString().replace(/\D/g, '') : ''
            }
            this.$store.commit('filterParams/SET_COST', cost)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    mounted() {
        $('#filterCity').on('hidden.bs.dropdown', () => {
            this.cost_from = this.stateParamsCostFrom
            this.cost_to = this.stateParamsCostTo
        })
        const cost_fromLS = localStorage.getItem('cost_from')
        const cost_toLS = localStorage.getItem('cost_to')
        const cost = {
            from: '',
            to: ''
        }
        if (cost_fromLS)  {
            this.cost_from = cost_fromLS
            cost.from = +cost_fromLS
        }
        if (cost_toLS) {
            this.cost_to = cost_toLS
            cost.to = +cost_fromLS
        }
        this.$store.commit('filterParams/SET_COST', cost)
    }
}
</script>

<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div class="d-flex flex-column">
            <input
                v-model="cost_from"
                @input="prettify('cost_from')"
                placeholder="От"
                type="text"
                class="border border-danger rounded-2 bg-transparent text-secondary px-1 mb-2"
            >
            <input
                v-model="cost_to"
                @input="prettify('cost_to')"
                placeholder="До"
                type="text"
                class="border border-danger rounded-2 bg-transparent text-secondary px-1 mb-2"
            >
        </div>
        <button @click.prevent="setCost()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<style scoped>

</style>
