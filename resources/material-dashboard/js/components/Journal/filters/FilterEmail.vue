<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
            <input
                @change="setAllEmail($event)"
                v-model="allEmailSelected"
                id="allEmail"
                class="form-check-input m-0 me-1"
                type="checkbox"
            >
            <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allEmail">
                Выбрать все
            </label>
        </div>
        <div
            v-for="(email_, emailIndex) in allEmail"
            :key="emailIndex"
            class="form-check m-0 p-0 d-flex align-items-center mb-2">
            <input
                v-model="email"
                :value="email_"
                :id="'id' + email_"
                class="form-check-input m-0 me-1"
                type="checkbox"
            >
            <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center" :for="'id' + email_">
                {{ email_ }}
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
        <button @click.prevent="setEmail()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterEmail",
    props: ['projectid'],
    data() {
        return {
            email: [],
            allEmailSelected: false,
            allEmail: null
        }
    },
    watch: {
        stateParamsEmail(email) {
            if(email) this.email = email
        },
        regions(arr) {
            if (arr.length === 0) this.allEmailSelected = false
            if (arr.length === this.allEmail.length) {
                this.allEmailSelected = true
            } else {
                this.allEmailSelected = false
            }
        },
    },
    computed: {
        stateParamsEmail() {
            return this.$store.getters['filterParams/stateParamsEmail']
        }
    },
    methods: {
        setAllEmail() {
            if (this.allEmailSelected) {
                this.email = this.allEmail.map(email => {
                    return email
                })
            } else {
                this.email = []
            }
        },
        async setEmail() {
            this.$store.commit('filterParams/SET_EMAIL', this.email)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterEmail').on('hidden.bs.dropdown', () => {
            this.email = this.stateParamsEmail
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'email'  } })
            .then(response => {
                console.log(response)
                this.allEmail = response.data
            })

        const emailLS = localStorage.getItem('email')
        if (emailLS) {
            this.email = JSON.parse(emailLS)
            if (this.email.length === this.allEmail.length) {
                this.allEmailSelected = true
            } else {
                this.allEmailSelected = false
            }
            this.$store.commit('filterParams/SET_EMAIL', this.email)
        }
    }
}
</script>


<style scoped>

</style>
