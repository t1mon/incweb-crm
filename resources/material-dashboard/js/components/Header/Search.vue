<template>
<!--    <form :class="{ 'search&#45;&#45;active' : focus || stateHeaderSearchPopup }" @submit.prevent="headerSearch(value)" action="#" class="search d-flex align-items-center">-->
<!--        <div class="input-group input-group-outline">-->
<!--            <header-search-popup v-if="stateHeaderSearchPopup"></header-search-popup>-->
<!--            <button class="search__button">-->
<!--                <span class="material-icons text-light">search</span>-->
<!--            </button>-->
<!--            <label class="form-label">Поиск по сайтам</label>-->
<!--            <input-->
<!--                v-model="value"-->
<!--                @focus="focus = true"-->
<!--                @blur="focus = false"-->
<!--                :style="stateHeaderSearchPopup ? 'border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;' : '' "type="text" class="form-control">-->
<!--        </div>-->
<!--    </form>-->
    <div :class="{ 'search--active' : focus || stateHeaderSearchPopup }" class="search">
        <form @submit.prevent="headerSearch(value)"  class="input-group">
            <header-search-popup v-if="stateHeaderSearchPopup"></header-search-popup>
            <button class="search__button">
                <span class="material-icons text-light">search</span>
            </button>
            <input
                :class="{ 'border-success' : focus || stateHeaderSearchPopup }"
                v-model="value"
                @focus="focus = true"
                @blur="focus = false"
                :style="stateHeaderSearchPopup ? 'border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;' : '' "
                type="text"
                class="form-control border rounded-0 p-1 px-2 text-light"
                placeholder="Поиск по сайтам"
            >
        </form>
    </div>
</template>

<script>
import HeaderSearchPopup from '../Others/HeaderSearchPopup'

export default {
    name: "HeaderSearch",
    components: {
        HeaderSearchPopup
    },
    data () {
        return {
            value: '',
            focus: false
        }
    },
    methods: {
        headerSearch (value) {
            this.$store.dispatch('headerSearch', value)
        }
    },
    computed: {
        stateHeaderSearchPopup () {
            return this.$store.getters.stateHeaderSearchPopup
        }
    }
}
</script>

<style scoped>
.search {
    transition: 0.5s;
}
.search--active {
    width: 100%;
    max-width: 500px;
}
.is-focused .headerSearchPopup {
    border-color: #e91e63;
}

.search__button {
    background-color: transparent;
    border: none;
    padding: 0;
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    right: 5px;
    transform: translateY(-50%);
    z-index: 5;
}
.dark-version .search__button {
    color: rgba(255, 255, 255, 0.8);
}
.input-group.input-group-outline .form-control {
    padding-right: 25px !important;
}
@media screen and (max-width: 575px) {
    .search {
        order: 3;
        width: 100%;
    }
}
</style>
