export default {
  namespaced: true,
  state() {
    return {
      journal: '',
      projectId: ''
    }
  },
  getters: {
    stateProjectId(state) {
      return state.projectId
    }
  },
  mutations: {
    SET_PROJECT_ID(state, id) {
      state.projectId = id
    }
  },
  actions: {
    async getJournalAll({ state, getters, commit, rootState, rootGetters }, data) {
      commit('loader/LOADER_TRUE', null, { root: true })
      const url = `/api/v2/project/${getters.stateProjectId}/journal`

      //Данные с хранилища vuex
      const filterParams = rootGetters['filterParams/stateParams']

      const params = {}

      //Данные с localStorage
      // const date_fromLS = localStorage.getItem('date_from')
      // const date_toLS = localStorage.getItem('date_to')
      const sort_byLS = localStorage.getItem('sort_by')
      const sort_orderLS = localStorage.getItem('sort_order')
      const nameLS = localStorage.getItem('name')
      const classesLS = localStorage.getItem('classes')
      const phoneLS = localStorage.getItem('phone')
      const entriesLS = localStorage.getItem('entries')
      const hostsLS = localStorage.getItem('hosts')
      const companyLS = localStorage.getItem('company')
      const regionsLS = localStorage.getItem('regions')
      const emailLS = localStorage.getItem('email')
      const citiesLS = localStorage.getItem('cities')
      const cost_fromLS = localStorage.getItem('cost_from')
      const cost_toLS = localStorage.getItem('cost_to')
      const referrerLS = localStorage.getItem('referrer')
      const utm_termLS = localStorage.getItem('utm_term')
      const utm_mediumLS = localStorage.getItem('utm_medium')
      const utm_sourceLS = localStorage.getItem('utm_source')
      const utm_campaignLS = localStorage.getItem('utm_campaign')
      const sourceLS = localStorage.getItem('source')

      if(classesLS && JSON.parse(classesLS).length > 0) params.class = JSON.parse(classesLS)
      // if (date_fromLS && date_toLS) {
      //   params.date_from = date_fromLS
      //   params.date_to = date_toLS
      // }
      if (sort_byLS && sort_orderLS) {
        params.sort_by = sort_byLS
        params.sort_order = sort_orderLS
      }
      if (nameLS) params.name = nameLS
      if (phoneLS) params.phone = phoneLS
      if (entriesLS) params.entry_filter = entriesLS
      if(hostsLS && JSON.parse(hostsLS).length > 0) params.host = JSON.parse(hostsLS)
      if(companyLS) params.company = companyLS
      if(regionsLS && JSON.parse(regionsLS).length > 0) params.manual_region = JSON.parse(regionsLS)
      if(emailLS) params.email = emailLS
      if(citiesLS && JSON.parse(citiesLS).length > 0) params.city = JSON.parse(citiesLS)
      if(cost_fromLS) params.cost_from = cost_fromLS
      if(cost_toLS) params.cost_to = cost_toLS
      if(referrerLS) params.referrer = referrerLS
      if(utm_termLS && JSON.parse(utm_termLS).length > 0) params.utm_term = JSON.parse(utm_termLS)
      if(utm_mediumLS && JSON.parse(utm_mediumLS).length > 0) params.utm_medium = JSON.parse(utm_mediumLS)
      if(utm_sourceLS && JSON.parse(utm_sourceLS).length > 0) params.utm_source = JSON.parse(utm_sourceLS)
      if(utm_campaignLS && JSON.parse(utm_campaignLS).length > 0) params.utm_campaign = JSON.parse(utm_campaignLS)
      if(sourceLS && JSON.parse(sourceLS).length > 0) params.source = JSON.parse(sourceLS)


      //Записываем данные с хранилища vuex
      if(filterParams.classes.length > 0) params.class = filterParams.classes
      if (filterParams.date_from) {
        params.date_from = filterParams.date_from
        params.date_to = filterParams.date_to
      }
      if (filterParams.sort_by) {
        params.sort_by = filterParams.sort_by
        params.sort_order = filterParams.sort_order
      }
      if (filterParams.name) params.name = filterParams.name
      if (filterParams.phone) params.phone = filterParams.phone
      if (filterParams.entries) params.entry_filter = filterParams.entries
      if (data && data.page) params.page = data.page
      if(filterParams.hosts && filterParams.hosts.length > 0) params.host = filterParams.hosts
      if(filterParams.company) params.company = filterParams.company
      if(filterParams.regions.length > 0) params.manual_region = filterParams.regions
      if(filterParams.email) params.email = filterParams.email
      if(filterParams.cities.length > 0) params.city = filterParams.cities
      if(filterParams.cost_from) params.cost_from = filterParams.cost_from
      if(filterParams.cost_to) params.cost_to = filterParams.cost_to
      if(filterParams.referrer) params.referrer = filterParams.referrer
      if(filterParams.utm_term.length > 0) params.utm_term = filterParams.utm_term
      if(filterParams.utm_medium.length > 0) params.utm_medium = filterParams.utm_medium
      if(filterParams.utm_source.length > 0) params.utm_source = filterParams.utm_source
      if(filterParams.utm_campaign.length > 0) params.utm_campaign = filterParams.utm_campaign
      if(filterParams.source.length > 0) params.source = filterParams.source
      await axios
        .get(url, {
          params: params
        })
        .then(data => {
          console.log(data)
          data.data.data.classes.unshift({
            color: "",
            id: "",
            name: "Не задан",
            project_id: data.data.data.id
          })
          commit('loader/LOADER_FALSE', null, { root: true })
          commit('SET_LEADS', data.data.data.leads.data, { root: true })
          commit('SET_PROJECT_JOUR', data.data.data, { root: true })
        })
        .catch(error => {
          commit('loader/LOADER_FALSE', null, { root: true })
          console.log(error)
        })
    }
  }
}
