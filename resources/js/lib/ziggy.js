import { route } from 'ziggy-js'

if (typeof window !== 'undefined' && window.Ziggy) {
  route().current = (name, params) => {
    const ziggy = window.Ziggy
    return ziggy.url === route(name, params, undefined, ziggy)
  }
}

export { route }
