import { createI18n } from 'vue-i18n'
import ptBr from './pt-br'
import en from './en'

const i18n = createI18n({
  legacy: false,
  locale: 'pt-br',
  fallbackLocale: 'en',
  messages: {
    'pt-br': ptBr,
    en: en
  }
})

export default i18n
