<template>
    <td v-if="lead" class="text-white text-center">
        <div class="dropdown">
            <a
                :style="`background: #${findClass(lead.class_id).color}; color: ${findClass(lead.class_id) ? '#ffffff' : ''}`"
                :id="'dropdownClasses' + lead.id"
                class="border border-success w-100 d-block"
                data-bs-toggle="dropdown" aria-expanded="false" href=""
            >{{ findClass(lead.class_id) ? findClass(lead.class_id).name : 'Не задан' }}</a>
            <div class="dropdown-menu dropdown-menu-dark border border-success p-0" aria-labelledby="dropdownProjectMenu">
                <div
                    v-for="projectClass in stateProjectJour.classes"
                    @click="getLeadClass(stateProjectJour.id, lead.id, projectClass.id)"
                    :class="{'bg-secondary' : lead.class_id === projectClass.id}"
                    class="d-flex justify-content-between align-items-center p-1 border-bottom border-success journal__class-item">
                        <span class="journal__class-name">{{ projectClass.name }}</span>
                        <span :style="'background:' + ' ' + '#' + projectClass.color" class="journal__class-color"></span>
                </div>
            </div>
        </div>
    </td>
</template>

<script>
export default {
    name: "JournalClasses",
    props: {
        lead: {
            required: true,
            type: Object
        }
    },
    computed: {
        stateProjectJour () {
            return this.$store.getters.stateProjectJour
        }
    },
    methods: {
        findClass(id) {
            if(!id) return false
            const _class = this.stateProjectJour.classes.find(el => {
                return el.id === id
            })
            return _class
        },
        async getLeadClass (projectId, leadId, classId) {
            const store = this.$store
            store.commit('loader/LOADER_TRUE')
            await axios.post(`/api/v1/project/${projectId}/journal/${leadId}/class/assign`, {
                class_id: classId
            })
                .then( (response) => {
                    store.commit('loader/LOADER_FALSE')
                    this.lead.class_id = classId
                })
                .catch(function (error) {
                    store.commit('loader/LOADER_FALSE')
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>
.journal__class-name {
    width: calc(100% - 20px);
    white-space: normal;
}
.journal__class-item:hover {
    background: #7b809a;
}
.journal__class-item:last-child{
    border: none !important;
}
.journal__class-color {
    width: 15px;
    height: 15px;
    display: block;
}
</style>
