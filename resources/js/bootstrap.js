import _ from 'lodash';

/**
 * Vamos carregar o jQuery e o plugin do Bootstrap para jQuery,
 * que fornece suporte para recursos baseados em JavaScript do Bootstrap,
 * como modais e abas. Este código pode ser modificado para se ajustar às necessidades do seu aplicativo.
 */

import * as Popper from 'popper.js';
import $ from 'jquery';
import 'bootstrap';
import 'admin-lte';

/**
 * Vamos carregar a biblioteca Axios, que nos permite facilmente realizar
 * requisições HTTP para o back-end do Laravel. Esta biblioteca lida automaticamente
 * com o envio do token CSRF como um cabeçalho com base no valor do cookie "XSRF".
 */

import axios from 'axios';

window._ = _; // Define lodash no global
window.Popper = Popper.default; // Define Popper no global
window.$ = window.jQuery = $; // Define jQuery no global
window.axios = axios; // Define axios no global

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Agora vamos registrar o token CSRF como um cabeçalho comum com o Axios
 * para que todas as requisições HTTP saindo automaticamente tenham o token.
 * Isto é apenas uma conveniência para não termos que adicionar o token manualmente.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
