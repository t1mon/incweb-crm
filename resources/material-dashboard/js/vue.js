import { createApp } from 'vue'
import store from './store'

import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/vue-tel-input.css';

//components
import SettingsBar from './components/Settings/SettingsBar'
import SettingsBasic from './components/Settings/SettingsBasic/SettingsBasic'
import Projects from './components/Projects/Projects'
import Journal from './components/Journal/Journal'
import HeaderSearch from './components/Header/Search'
import NavbarProjects from './components/Navbar/NavbarProjects'
import LoaderApp from './components/Others/Spinner'
import directives from './directives'

const app = createApp({
  components: {
    SettingsBar,
    SettingsBasic,
    Projects,
    Journal,
    HeaderSearch,
    NavbarProjects,
    LoaderApp
  },
  mounted () {
    $('[data-confirm]').on('click', () => {
      return confirm($(this).data('confirm'))
    })
  }
})

const globalOptionsVTI = {
  mode: 'international',
  autoFormat: true,
  validCharactersOnly: true,
  inputOptions: {
    showDialCode: true,
    placeholder: ''
  }
};

app.use(VueTelInput, globalOptionsVTI)
directives(app)
app.use(store)

app.mount('#app')
