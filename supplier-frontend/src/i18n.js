import { createI18n } from 'vue-i18n'
import ptBr from './locales/pt-br'
import en from './locales/en'

const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem('lang') || 'pt-br',
  fallbackLocale: 'en',
  messages: {
    'pt-br': ptBr,
    en
  }
})

export default i18n
