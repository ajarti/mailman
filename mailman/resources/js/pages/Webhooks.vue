<template>
				<div class="q-pa-md">

								<q-form
																autocomplete="off"
																@submit.prevent.stop="saveCallback"
																class="q-pa-md"
								>

												<div class="text-h4">Webhooks</div>
												<p class=" q-mt-md text-body1 text-weight-light text-grey">
																In order for the 3rd Party delivery services to update the system, they need a callback URL.
												</p>
												<div class="row q-mt-md  q-col-gutter-lg">
																<div class="col">
																				<q-input
																												clearable
																												hide-hint
																												hint="Browse to 127.0.0.1:4040 and copy the secure url including the https://."
																												label="NGROK Callback URL"
																												lazy-rules
																												:rules="[ val => val && val.length > 0 || 'We need a callback URL for the webhooks.']"
																												v-model.trim="callback_url"
																				></q-input>
																				<a class="text-caption text-weight-light q-pt-xl" href="http://127.0.0.1:4040/" target="_blank">Open Ngrok link in a new tab.</a>
																</div>
												</div>

												<div class="row q-mt-md q-col-gutter-lg">
																<div class="col">
																				<q-btn :loading="updating" label="Update Callbacks" type="submit" color="primary"></q-btn>
																</div>
												</div>
								</q-form>

				</div>
</template>

<script>

	export default {
		computed : {},
		name     : 'Webhook',
		data()
		{
			return {
				callback_url : '',
				updating     : false
			}
		},
		methods  : {
			saveCallback()
			{
				// Send Message.
				var self      = this;
				self.updating = true;
				axios.post('/api/webhook', {
					callback_url : _.get(self, 'callback_url', ''),
				}).then(function(response){
					self.updating = false;
					if ( _.has(response, 'data.status') && _.isEqual(response.data.status, 'success') ) {
						self.$q.notify({
							position : 'top',
							color    : 'positive',
							message  : 'All the distribution services have been updated with the new webhook url.'
						});
						return;
					}
					self.$q.notify({
						position : 'top',
						color    : 'positive',
						message  : 'The server responded positively, but did not report success, best to check with support.'
					});
				})
					.catch(function(error){
						self.updating = false;
					});

			}
		},
		mounted()
		{
			console.log('Webhook Mounted ..');
		}
	}
</script>

