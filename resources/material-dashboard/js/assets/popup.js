function britvaPopup() {
  const britvaPopups = document.querySelectorAll('[data-britva-popup]')
  britvaPopups.forEach(popup => {
    let children = popup.children
    children = Array.from(children)
    const trigger = children.find(el => {
      return el.hasAttribute('data-britva-popup-trigger')
    })
    const menu = children.find(el => {
      return el.hasAttribute('data-britva-popup-menu')
    })
    if(trigger && menu && trigger != menu) {
      trigger.onclick = e => {
        e.preventDefault()
        e.stopPropagation()
        menu.classList.toggle('britva__popup-menu--active')
        document.addEventListener('click', () => menu.classList.remove('britva__popup-menu--active'), {once: true})
      }
      menu.onclick = e => e.stopPropagation()
      const close = menu.querySelector('[data-britva-popup-close]')
      if (close) {
        close.onclick = () => menu.classList.remove('britva__popup-menu--active')
      }
    }
  })
}

const target = document.getElementById("app");

// Конфигурация observer (за какими изменениями наблюдать)
const config = {
  attributes: true,
  childList: true,
  subtree: true,
};

const observer = new MutationObserver(britvaPopup);

observer.observe(target, config);
