<template>
    <div class="px-2 pt-2 d-flex flex-column">

        <div style="overflow: auto; max-height: 200px; max-width: 200px">
            <div class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    @change="setAllUtmCampaign($event)"
                    v-model="allUtmCampaignSelected"
                    id="allUtmCampaign"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center font-weight-bolder" for="allUtmCampaign">
                    Выбрать все
                </label>
            </div>
            <div
                v-for="(utm_campaign_, utm_campaignIndex) in allUtmCampaign"
                :key="utm_campaignIndex"
                class="form-check m-0 p-0 d-flex align-items-center mb-2">
                <input
                    v-model="utm_campaign"
                    :value="utm_campaign_"
                    :id="'id' + utm_campaign_"
                    class="form-check-input m-0 me-1"
                    type="checkbox"
                >
                <label style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; width: 160px" class="d-block form-check-label m-0 text-xxs lh-sm align-items-center" :for="'id' + utm_campaign_">
                    {{ utm_campaign_ }}
                </label>
            </div>
        </div>
        <button @click.prevent="setUtmCampaign()" class="btn btn-info rounded-0 mb-0 py-1 px-3 w-100 mb-2" style="height: max-content">Отфильтровать</button>
    </div>
</template>

<script>
export default {
    name: "FilterUTMSource",
    props: ['projectid'],
    data() {
        return {
            utm_campaign: [],
            allUtmCampaignSelected: false,
            allUtmCampaign: null
        }
    },
    watch: {
        stateParamsUtmCampaign(utm_campaign) {
            if(utm_campaign) this.utm_campaign = utm_campaign
        },
        utm_campaign(arr) {
            if (arr.length === 0) this.allUtmCampaignSelected = false
            if (arr.length === this.allUtmCampaign.length) {
                this.allUtmCampaignSelected = true
            } else {
                this.allUtmCampaignSelected = false
            }
        },
    },
    computed: {
        stateParamsUtmCampaign() {
            return this.$store.getters['filterParams/stateParamsUtmCampaign']
        }
    },
    methods: {
        setAllUtmCampaign() {
            if (this.allUtmCampaignSelected) {
                this.utm_campaign = this.allUtmCampaign.map(utm_campaign => {
                    return utm_campaign
                })
            } else {
                this.utm_campaign = []
            }
        },
        async setUtmCampaign() {
            this.$store.commit('filterParams/SET_UTM_CAMPAIGN', this.utm_campaign)
            await this.$store.dispatch('journalAll/getJournalAll')
        }
    },
    created() {
    },
    async mounted() {
        $('#filterUTMCampaign').on('hidden.bs.dropdown', () => {
            this.utm_campaign = this.stateParamsUtmCampaign
        })
        await axios.get(`/api/v2/project/${this.projectid}/journal/variants`, { params: { column: 'utm_campaign' } })
            .then(response => {
                // console.log(response)
                this.allUtmCampaign = response.data
            })

        const utm_campaignLS = localStorage.getItem('utm_campaign')
        if (utm_campaignLS) {
            this.utm_campaign = JSON.parse(utm_campaignLS)
            if (this.utm_campaign.length === this.allUtmCampaign.length) {
                this.allUtmCampaignSelected = true
            } else {
                this.allUtmCampaignSelected = false
            }
            this.$store.commit('filterParams/SET_UTM_CAMPAIGN', this.utm_campaign)
        }
    }
}
</script>


<style scoped>

</style>
