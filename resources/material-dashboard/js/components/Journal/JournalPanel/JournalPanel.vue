<template>

    <div v-if="stateProjectJour" class="d-flex flex-column flex-lg-row justify-content-between align-items-stretch gap-2 mb-2">
        <div class="d-flex align-items-stretch justify-content-between gap-2">
            <h5 class="m-0 w-50 w-md-25 w-lg-auto text-sm d-flex align-items-center">{{ stateProjectJour.name }}</h5>

            <journal-panel-filter></journal-panel-filter>
        </div>

        <div class="d-flex flex-column-reverse flex-lg-row just align-items-stretch gap-2">
            <div class="d-flex flex-row-reverse flex-lg-row justify-content-between align-items-stretch gap-2">
                <clear-filters></clear-filters>
                <columns-settings :columns="columns" @changeColumnsSettings="changeColumnsSettings"></columns-settings>
            </div>
            <div class="d-flex gap-2 justify-content-between">
                <manual-leads></manual-leads>
                <button @click.prevent="exportJournal()" class="journal__date__button--last btn btn-success rounded-0 mb-0 py-1 px-3 w-50 w-md-25 w-lg-auto" > Скачать записи </button>
            </div>
        </div>
    </div>

</template>

<script>
import JournalPanelFilter from "./JournalPanelFilter";
import ClearFilters from "./ClearFilters";
import ManualLeads from "./ManualLeads";
import ColumnsSettings from "./ColumnsSettings.vue";

export default {
    name: "JournalPanel",
    components: {
        JournalPanelFilter,
        ClearFilters,
        ManualLeads,
        ColumnsSettings
    },
    props: {
        columns: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
        }
    },
    computed: {
        stateProjectJour () {
            return this.$store.getters.stateProjectJour
        }
    },
    methods: {
        changeColumnsSettings(column) {
            this.$emit('changeColumnsSettings', column)
        },
        getFilteredLeads (_projectId, _dateFrom, _dateTo) {
            this.$store.dispatch('getLeads', { projectId: _projectId, dateFrom: _dateFrom, dateTo: _dateTo })
            localStorage.setItem('dateFrom', _dateFrom)
            localStorage.setItem('dateTo', _dateTo)
        },
        exportJournal () {
            const query = {
                date_from: this.$store.getters['filterParams/stateParams'].date_from,
                date_to: this.$store.getters['filterParams/stateParams'].date_to
            }
            const url = window.location.href + `/download?` + $.param(query)
            window.location = url
        }
    }
}
</script>

<style scoped>
.form-control {
    padding: 0 !important;
}

.journal__date__dates {
    margin-right: 16px;
}

.journal__date__button {
}
.journal__date__buttons {
    display: flex;
    align-items: flex-end;
}
.journal__date__button--first {
    margin-right: 16px;
}

@media screen and (max-width: 991px) {
    .journal__date__dates {
        margin-right: 0;
        margin-bottom: 5px;
    }
    .journal__date__button {
        width: 100%;
    }
    .journal__date__buttons {
        padding: 0 4px;
    }
}
@media screen and (max-width: 767px) {
    .input-group {
        max-width: 50%;
    }
    .journal__date__button--last {
        margin: 0;
    }
}
</style>
