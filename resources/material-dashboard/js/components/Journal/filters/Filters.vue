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

export default {
    props: ['ascDesc', 'name', 'filterClass', 'filterPhone', 'filterEntries', 'filterHosts', 'filterCompany', 'projectid'],
    name: "Filters",
    components: {
        filterAscDesc,
        filterName,
        filterClass,
        filterPhone,
        filterEntries,
        filterHosts,
        filterCompany
    }
}
</script>

<style scoped>
.filters {
    border: 1px solid #7B809A;
    border-radius: 4px;
}
</style>
