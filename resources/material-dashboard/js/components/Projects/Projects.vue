<template>
    <div>
        <div v-show="stateProjects && stateProjects.length > 0" class="projects">
            <div class="">
                <div class="text-left d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                    <h5 class="m-0">Проекты</h5>
                    <projects-search></projects-search>
                    <a href="/project/create" class="btn bg-gradient-info rounded-0 mb-0 mt-0 mt-lg-0 p-2 px-4">
                        <i class="material-icons text-white position-relative text-md">add</i> Добавить
                    </a>
                </div>
            </div>

            <projects-list ref="hide"></projects-list>
        </div>
        <div v-if="stateProjects && stateProjects.length === 0">
            <h2 class="projects__title projects__title--empty">Нет ни одного проекта!</h2>
            <div class="col-md-12 my-auto text-center">
                <a href="/project/create" class="btn bg-gradient-primary mb-0 mt-0 mt-lg-0">
                    <i class="material-icons text-white position-relative text-md pe-2">add</i> Добавить первый проект
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import ProjectsList from './ProjectsList'
import ProjectsSearch from './ProjectsSearch'
import Spinner from '../Others/Spinner'

export default {
  name: 'Index',
  components: {
    ProjectsList,
    ProjectsSearch,
    Spinner
  },
  computed: {
    checkCards () {
      return this.$store.getters.stateCards
    },
    stateProjects () {
      return this.$store.getters.stateProjects
    }
  },
    methods: {
        async getProjects () {
            await this.$store.dispatch('getProjects')
        },
        async getLeadsCount () {
            await this.$store.dispatch('getLeadsCount')
        }
    },
  async created () {
    await this.getProjects()
    await this.getLeadsCount()
  }
}
</script>

<style scoped>
@keyframes show {
    0% { transform: perspective(400px) translateZ(-100px); }
    100% { transform: none; }
}

.projects__title--empty {
    text-align: center;
    padding-top: 40px;
    margin-bottom: 30px;
}

.projects__content--show {
    animation: show 0.5s ease;
}

.projects {
    position: relative;
}

@media screen and (max-width: 575px) {
    .projects__row {
        padding: 10px 0;
    }
}

</style>
