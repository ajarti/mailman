/**
 * Bootstrap App.
 */
require('./bootstrap');

/**
 * Configure Vue.
 */
Vue.config.devtools = true;

/**
 * Configure Quasar.
 */
Quasar.iconSet.set(Quasar.iconSet.fontawesomeV5) // fontawesomeV5 is just an example


/**
 * Configure Router.
 */
import MailmanLayout from './layouts/MailmanLayout';
import CreateEmail from './pages/CreateEmail';
import Webhooks from './pages/Webhooks';

const router = new VueRouter({
	routes : [
		{
			path      : '/',
			component : MailmanLayout,
			children  : [
				{
					name : 'create',
					path : 'create', components : {
						default : CreateEmail,
					}
				},
				{
					name : 'webhooks',
					path : 'webhooks', components : {
						default : Webhooks,
					}
				},
			]
		}
	],
	scrollBehavior(to, from, savedPosition)
	{
		return new Promise((resolve, reject) => {
			setTimeout(() => {
				resolve({ x : 0, y : 0 })
			}, 500)
		})
	}
});

/**
 * Setup App.
 */
new Vue({
	created()
	{
		console.log('Mailman Creating.');
		// this.seedStore();
	},
	el      : '#mailman-app',
	data()
	{
		return {
			leftDrawerOpen : false,
		}
	},
	methods : {
		loadServices()
		{
			var self = this;
			axios.get('/api/services')
				.then((response) => {
					if ( response
						&& _.has(response, 'status')
						&& _.isEqual(parseInt(response.status), 200)
						&& _.has(response, 'data')
						&& _.has(response.data, 'data')
					) {
						self.$store.dispatch('updateServices', response.data.data);
					}
				})
				.catch(() => {
					// Basic recovery, redundancy would be needed in production.
					console.log('Services could not be loaded.');
					this.$q.notify({
						color    : 'negative',
						icon     : 'warning',
						message  : 'Services could not be loaded.',
						position : 'top-right'
					})
				})
		},
		seedStore()
		{
			this.loadServices();
		}
	},
	mounted()
	{
		console.log('Mailman Mounted ..');
	},
	router
})
