export default {
  namespaced: true,
  state() {
    return {
      params: {
        source: [],
        utm_campaign: [],
        utm_source: [],
        utm_medium: [],
        utm_term: [],
        referrer: '',
        cities: [],
        email: '',
        regions: [],
        company: '',
        date_from: '',
        date_to: '',
        sort_by: '',
        sort_order: '',
        name: '',
        classes: [],
        phone: '',
        entries: '',
        hosts: null,
        cost_from: '',
        cost_to: ''
      }
    }
  },
  getters: {
    stateParamsSource(state) {
      return state.params.source
    },
    stateParamsUtmCampaign(state) {
      return state.params.utm_campaign
    },
    stateParamsUtmSource(state) {
      return state.params.utm_source
    },
    stateParamsUtmMedium(state) {
      return state.params.utm_medium
    },
    stateParamsUtmTerm(state) {
      return state.params.utm_term
    },
    stateParamsReferrer(state) {
      return state.params.referrer
    },
    stateParamsCostFrom(state) {
      return state.params.cost_from
    },
    stateParamsCostTo(state) {
      return state.params.cost_to
    },
    stateParamsCities(state) {
      return state.params.cities
    },
    stateParamsEmail(state) {
      return state.params.email
    },
    stateParamsRegions(state) {
      return state.params.regions
    },
    stateParamsCompany(state) {
      return state.params.company
    },
    stateParamsHosts(state) {
      return state.params.hosts
    },
    stateParamsDateFrom(state) {
      return state.params.date_from
    },
    stateParamsDateTo(state) {
      return state.params.date_to
    },
    stateParams(state) {
      return state.params
    },
    stateParamsEntries(state) {
      return state.params.entries
    },
    stateParamsClasses(state) {
      return state.params.classes
    },
    stateParamsName(state) {
      return state.params.name
    },
    stateParamsPhone(state) {
      return state.params.phone
    }
  },
  mutations: {
    SET_SOURCE(state, arr) {
      state.params.source = arr.map(id => {
        return id
      })
      localStorage.setItem('source', JSON.stringify(arr))
    },
    SET_UTM_CAMPAIGN(state, arr) {
      state.params.utm_campaign = arr.map(id => {
        return id
      })
      localStorage.setItem('utm_campaign', JSON.stringify(arr))
    },
    SET_UTM_SOURCE(state, arr) {
      state.params.utm_source = arr.map(id => {
        return id
      })
      localStorage.setItem('utm_source', JSON.stringify(arr))
    },
    SET_UTM_MEDIUM(state, arr) {
      state.params.utm_medium = arr.map(id => {
        return id
      })
      localStorage.setItem('utm_medium', JSON.stringify(arr))
    },
    SET_UTM_TERM(state, arr) {
      state.params.utm_term = arr.map(id => {
        return id
      })
      localStorage.setItem('utm_term', JSON.stringify(arr))
    },
    SET_REFERRER(state, referrer) {
      state.params.referrer = referrer
      localStorage.setItem('referrer', referrer)
    },
    SET_COST(state, cost) {
      state.params.cost_from = cost.from
      state.params.cost_to = cost.to
      localStorage.setItem('cost_from', cost.from)
      localStorage.setItem('cost_to', cost.to)
    },
    SET_CITIES(state, arr) {
      state.params.cities = arr.map(id => {
        return id
      })
      localStorage.setItem('cities', JSON.stringify(arr))
    },
    SET_EMAIL(state, email) {
      state.params.email = email
      localStorage.setItem('email', email)
    },
    SET_REGIONS(state, arr) {
      state.params.regions = arr.map(id => {
        return id
      })
      localStorage.setItem('regions', JSON.stringify(arr))
    },
    SET_COMPANY(state, company) {
      state.params.company = company
      localStorage.setItem('company', company)
    },
    SET_HOSTS(state, hosts) {
      state.params.hosts = hosts.map(host => {
        return host
      })
      localStorage.setItem('hosts', JSON.stringify(hosts))
    },
    SET_ENTRIES(state, entries) {
      state.params.entries = entries
      localStorage.setItem('entries', entries)
    },
    SET_PHONE(state, phone) {
      state.params.phone = phone
      localStorage.setItem('phone', phone)
    },
    SET_CLASSES(state, arr) {
      state.params.classes = arr.map(id => {
        return id
      })
      localStorage.setItem('classes', JSON.stringify(arr))
    },
    SET_NAME(state, name) {
      state.params.name = name
      localStorage.setItem('name', name)
    },
    SET_DATE_FROM(state, dateFrom) {
      state.params.date_from = dateFrom
    },
    SET_DATE_TO(state, dateTo) {
      state.params.date_to = dateTo
    },
    SET_SORT_BY(state, val) {
      state.params.sort_by = val
      localStorage.setItem('sort_by', val)
    },
    SET_SORT_ORDER(state, val) {
      state.params.sort_order = val
      localStorage.setItem('sort_order', val)
    },
    CLEAR_PARAMS(state) {
      state.params = {
        source: [],
        utm_campaign: [],
        utm_source: [],
        utm_medium: [],
        utm_term: [],
        referrer: '',
        date_from: '',
        date_to: '',
        sort_by: '',
        sort_order: '',
        name: '',
        classes: [],
        phone: '',
        entries: '',
        hosts: [],
        company: '',
        regions: [],
        email: '',
        cities: [],
        cost_from: '',
        cost_to: '',
      }
      localStorage.removeItem('date_from')
      localStorage.removeItem('date_to')
      localStorage.removeItem('columnIndex')
      localStorage.removeItem('itemIndex')
      localStorage.removeItem('sort_by')
      localStorage.removeItem('sort_order')
      localStorage.removeItem('name')
      localStorage.removeItem('classes')
      localStorage.removeItem('phone')
      localStorage.removeItem('entries')
      localStorage.removeItem('hosts')
      localStorage.removeItem('company')
      localStorage.removeItem('regions')
      localStorage.removeItem('email')
      localStorage.removeItem('cities')
      localStorage.removeItem('cost_from')
      localStorage.removeItem('cost_to')
      localStorage.removeItem('referrer')
      localStorage.removeItem('utm_term')
      localStorage.removeItem('utm_medium')
      localStorage.removeItem('utm_source')
      localStorage.removeItem('utm_campaign')
      localStorage.removeItem('source')
    }
  }
}
