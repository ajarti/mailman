/**
 * Configure Lodash.
 */
window._ = require('lodash');


/**
 * Configure Axios
 */

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.post['Content-Type'] = 'application/json;charset=utf-8';
window.axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';

/**
 * Configure CSRF Token.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if ( token ) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
