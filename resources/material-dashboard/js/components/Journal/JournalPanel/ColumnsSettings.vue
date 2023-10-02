<template>
    <div data-britva-popup class="cursor-pointer w-50 w-md-25 w-lg-auto">
        <button data-britva-popup-trigger class="btn btn-info rounded-0 mb-0 py-1 px-3 h-100 w-100">Настроить столбцы</button>
        <div data-britva-popup-menu class="britva__popup-menu">

            <i data-britva-popup-close class="material-icons-round britva__popup-menu__close">close</i>

            <div
                v-for="(column, columnIndex) in columns"
                :class="{'d-none' : columnIndex === 'nextcall_date'}"
                class="mb-2">
                <div  class="form-check m-0 p-0 d-flex align-items-center pb-1">
                    <input
                        @change="changeColumnsSettings(columnIndex)"
                        v-model="columnsSettings"
                        :value="columnIndex"
                        :id="columnIndex"
                        class="form-check-input m-0 me-1"
                        type="checkbox"
                    >
                    <label class="form-check-label m-0 text-xxs lh-sm d-flex align-items-center" :for="columnIndex">
                        {{ columnIndex }}
                    </label>
                </div>
                <hr class="horizontal light m-0">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ColumnsSettings",
    props: {
        columns: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            columnsSettings: []
        }
    },
    methods: {
        changeColumnsSettings(column) {
            this.$emit('changeColumnsSettings', column)
        }
    },
    created() {
        for (const key in this.columns) {
            if(this.columns[key]) {
                this.columnsSettings.push(key)
            }
        }
    }
}
</script>

<style scoped>
.dropdown-menu::before {
    color: #e91e63;
}
</style>
