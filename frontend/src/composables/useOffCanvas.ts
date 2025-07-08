import { Offcanvas } from 'bootstrap'

export function useOffcanvas(id: string) {
  const getElement = (): HTMLElement | null => {
    return document.getElementById(id)
  }

  const getInstance = (): Offcanvas | null => {
    const el = getElement()
    if (!el) return null
    return Offcanvas.getOrCreateInstance(el)
  }

  const open = () => {
    closeAll() // fecha qualquer outro aberto
    getInstance()?.show()
  }

  const close = () => {
    getInstance()?.hide()
  }

  const toggle = () => {
    const el = getElement()
    if (!el) return

    const instance = Offcanvas.getOrCreateInstance(el)
    const isShown = el.classList.contains('show')

    isShown ? instance.hide() : instance.show()
  }

  const closeAll = () => {
    document.querySelectorAll('.offcanvas.show').forEach((el) => {
      const inst = Offcanvas.getInstance(el as HTMLElement)
      inst?.hide()
    })
  }

  return {
    open,
    close,
    toggle,
    instance: getInstance,
    element: getElement,
  }
}
