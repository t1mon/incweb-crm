import './bootstrap'
import './popper'
import './vue'
//import './material-dashboard'

      const sidenav = document.querySelector('.sidenav')
      const sidenavClose = document.querySelector('.sidenav-close')
      const sidenavBurger = document.querySelector('.sidenav-burger')

      sidenavClose.addEventListener('click', () => {
        sidenav.classList.remove('sidenav--active')
      })

      sidenavBurger.addEventListener('click', () => {
        sidenav.classList.add('sidenav--active')
      })
  console.log(sidenav, sidenavClose, sidenavBurger)

