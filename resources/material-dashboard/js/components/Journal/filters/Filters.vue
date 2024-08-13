<template>
    <div class="filters border py-2">
        <div>
            <filter-asc-desc v-if="ascDesc" :sort_order="ascDesc.sort_order" :sort_by="ascDesc.sort_by"></filter-asc-desc>
            <filter-name v-if="name"></filter-name>
            <filter-class v-if="filterClass"></filter-class>
            <filter-phone v-if="filterPhone"></filter-phone>
            <filter-entries v-if="filterEntries"></filter-entries>
            <filter-hosts :projectid="projectid" v-if="filterHosts"></filter-hosts>
            <filter-company :projectid="projectid" v-if="filterCompany"></filter-company>
            <filter-regions :projectid="projectid" v-if="filterRegions"></filter-regions>
            <filter-email :projectid="projectid" v-if="filterEmail"></filter-email>
            <filter-city :projectid="projectid" v-if="filterCity"></filter-city>
            <filter-cost :projectid="projectid" v-if="filterCost"></filter-cost>
            <filter-referrer :projectid="projectid" v-if="filterReferrer"></filter-referrer>
            <filter-utm-term :projectid="projectid" v-if="filterUTMTerm"></filter-utm-term>
            <filter-utm-medium :projectid="projectid" v-if="filterUTMMedium"></filter-utm-medium>
            <filter-utm-source :projectid="projectid" v-if="filterUTMSource"></filter-utm-source>
            <filter-utm-campaign :projectid="projectid" v-if="filterUTMCampaign"></filter-utm-campaign>
            <filter-source :projectid="projectid" v-if="filterSource"></filter-source>
        </div>
    </div>
</template>

<script>
import filterAscDesc from "./FilterAscDesc";
import filterName from "./FilterName";
import filterClass from "./FilterClass";
import filterPhone from "./FilterPhone";
import filterEntries from "./FilterEntries";
import filterHosts from "./FilterHosts";
import filterCompany from "./FilterCompany";
import filterRegions from "./FilterRegions";
import filterEmail from "./FilterEmail";
import filterCity from "./FilterCity";
import filterCost from "./FilterCost";
import filterReferrer from "./FilterReferrer";
import filterUtmTerm from "./FilterUTMTerm";
import filterUtmMedium from "./FilterUTMMedium";
import filterUtmSource from "./FilterUTMSource";
import filterUtmCampaign from "./FilterUTMCampaign";
import filterSource from "./FilterSource";

export default {
    props: [
        'ascDesc',
        'name',
        'filterClass',
        'filterPhone',
        'filterEntries',
        'filterHosts',
        'filterCompany',
        'filterRegions',
        'filterEmail',
        'filterCity',
        'filterCost',
        'filterReferrer',
        'filterUTMTerm',
        'filterUTMMedium',
        'filterUTMSource',
        'filterUTMCampaign',
        'filterSource',
        'projectid'
    ],
    name: "Filters",
    components: {
        filterAscDesc,
        filterName,
        filterClass,
        filterPhone,
        filterEntries,
        filterHosts,
        filterCompany,
        filterRegions,
        filterEmail,
        filterCity,
        filterCost,
        filterReferrer,
        filterUtmTerm,
        filterUtmMedium,
        filterUtmSource,
        filterSource,
        filterUtmCampaign
    }
}
</script>

<style scoped>
.filters {
    border: 1px solid #7B809A;
    border-radius: 4px;
}
</style>
