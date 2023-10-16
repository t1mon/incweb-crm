<template>
    <div class="px-2 pt-2 d-flex flex-column">
        <div
            v-for="(host, hostIndex) in allHosts"
            :key="host.id"
            class="form-check m-0 p-0 d-flex align-items-center mb-2">
            <input
                v-model="hosts"
                :value="host.host"
                :id="'host' + host.id"
                class="form-check-input m-0 me-1"
                type="checkbox"
            >
            <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center" :for="'host' + host.id">
                {{ host.host }}
            </label>
        </div>
        <button @click.prevent="setHosts()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterSites",
    props: ['projectid'],
    data() {
        return {
            hosts: [],
            allHosts: null
        }
    },
    watch: {
        stateParamsHosts(hosts) {
            if(hosts) this.hosts = hosts
        }
    },
    computed: {
        stateParamsHosts() {
            return this.$store.getters['filterParams/stateParamsHosts']
        }
    },
    methods: {
        async setHosts() {
            this.$store.commit('filterParams/SET_HOSTS', this.hosts)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
        const hostsLS = localStorage.getItem('hosts')
        if (hostsLS) {
            this.hosts = JSON.parse(hostsLS)
            this.$store.commit('filterParams/SET_HOSTS', this.hosts)
        }
    },
    mounted() {
        console.log(this.projectid)
        $('#filterHost').on('hidden.bs.dropdown', () => {
            this.hosts = this.stateParamsHosts
        })
        axios.get(`/api/v1/project/${this.projectid}/hosts`)
            .then(response => {
                this.allHosts = response.data.data
            })
    }
}
</script>


<style scoped>

</style>
