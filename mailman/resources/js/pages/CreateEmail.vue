<template>
				<div class="q-pa-md">

								<q-form
																autocomplete="off"
																@submit.prevent.stop="sendMessage"
																@reset="resetForm"
																class="q-pa-md"
								>
												<div class="text-h4">Send a Message</div>
												<p class=" q-mt-md text-body1 text-weight-light text-grey">
															Just a simple interface to allow one to send an email to the trafficking system.
												</p>

												<div class="row q-col-gutter-lg">
																<div class="col col-sm-4">
																				<q-input
																												hide-hint
																												hint="Who is this message for?"
																												label="TO"
																												lazy-rules
																												ref="to_name"
																												:rules="[ val => val && val.length > 0 || 'Who is this email for?']"
																												v-model.trim="message.to_name"
																				></q-input>
																</div>
																<div class="col col-sm-4">
																				<q-input
																												autocomplete="new-password"
																												hide-hint
																												hint="Email address of this recipient?"
																												label="TO EMAIL"
																												lazy-rules
																												ref="to_email"
																												:rules="[ val => isEmail(val) || 'The supplied email is invalid.']"
																												type="email"
																												v-model.trim="message.to_email"
																				></q-input>
																</div>
																<div class="col col-sm-4">
																				<q-field label="PRIORITY" borderless stack-label>
																								<q-option-group
																																color="primary"
																																inline
																																:options="priorities"
																																ref="priority"
																																v-model="message.priority"
																								></q-option-group>
																				</q-field>
																</div>
												</div>

												<div class="row q-mt-md  q-col-gutter-lg">
																<div class="col col-sm-4">
																				<q-input
																												hide-hint
																												hint="Who is this message from?"
																												label="FROM"
																												lazy-rules
																												ref="from_name"
																												:rules="[ val => val && val.length > 0 || 'Who is this email from?']"
																												v-model.trim="message.from_name"
																				></q-input>
																</div>
																<div class="col col-sm-4">
																				<q-input
																												:rules="[ val => isEmail(val) || 'The sender email is invalid.']"
																												autocomplete="new-password"
																												hide-hint
																												hint="Email address of the sender?"
																												label="FROM EMAIL"
																												lazy-rules
																												ref="from_email"
																												type="email"
																												v-model.trim="message.from_email"
																				></q-input>
																</div>
																<div class="col col-sm-4">
																				<q-input
																												hide-hint
																												hint="5 digit dummy client id"
																												label="CLIENT ID"
																												lazy-rules
																												mask="#####"
																												ref="client_id"
																												:rules="[ val => val && val.length == 5 || 'We need a 5 digit dummy client id.']"
																												type="text"
																												v-model.trim="message.client_id"
																				></q-input>
																</div>
												</div>

												<div class="row q-mt-md q-col-gutter-lg">
																<div class="col">
																				<q-input
																												hide-hint
																												hint="What is the message about?"
																												label="SUBJECT"
																												lazy-rules
																												ref="subject"
																												:rules="[ val => val && val.length > 0 || 'We need a subject for this message.']"
																												v-model.trim="message.subject"
																				></q-input>
																</div>
												</div>

												<div class="row q-mt-md q-col-gutter-lg">
																<div class="col-sm-8">
																				<div class="text-subtitle1 text-grey-7 q-mb-xs">MESSAGE CONTENT</div>
																				<editor
																												@change="updateHtmlAndText"
																												height="350px"
																												:options="editorOptions"
																												previewStyle="vertical"
																												ref="tuiEditor"
																												v-model="message.markdown"
																				></editor>
																				<div class="q-mt-xs text-caption text-negative" v-if="contentError">Please provide the content for this message.</div>
																</div>
																<div class="col-sm-4">
																				<q-input
																												autogrow
																												borderless
																												label="AUTO-GENERATED TEXT VERSION"
																												readonly
																												type="textarea"
																												v-model="message.text"
																				></q-input>
																</div>
												</div>

												<div class="row q-mt-md q-col-gutter-lg">
																<div class="col">
																				<q-btn :loading="sending" label="Send Message" type="submit" color="primary"></q-btn>
																				<q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm"></q-btn>
																</div>
												</div>
								</q-form>

				</div>
</template>

<script>
	import 'tui-editor/dist/tui-editor.css';
	import 'tui-editor/dist/tui-editor-contents.css';
	import 'codemirror/lib/codemirror.css';
	import {Editor} from '@toast-ui/vue-editor'

	export default {
		components : {
			'editor' : Editor
		},
		computed   : {},
		name       : 'CreateEmail',
		data()
		{
			return {
				contentError  : false,
				editorOptions : {
					hideModeSwitch : false,
					toolbarItems   : [
						'heading',
						'bold',
						'italic',
						'divider',
						'hr',
						'quote',
						'divider',
						'ul',
						'ol',
						'indent',
						'outdent',
						'divider',
						'table',
						'image',
						'link',
					]
				},
				message       : {
					client_id  : '',
					from_email : '',
					from_name  : '',
					html       : '',
					markdown   : '',
					priority   : 3,
					subject    : '',
					text       : '',
					to_email   : '',
					to_name    : '',
				},
				priorities    : [
					{
						label : 'High',
						value : 1
					},
					{
						label : 'Normal',
						value : 3
					},
					{
						label : 'Low',
						value : 5
					}
				],
				sending       : false
			}
		},
		methods    : {
			isEmail(email = '')
			{
				const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(String(email).toLowerCase());
			},
			messageIsValid()
			{
				if ( !_.has(this, 'message.html') || _.isEmpty(this.message.html) ) {
					this.contentError = true;
					return false
				}
				return true;
			},
			resetForm()
			{
				var self = this;

				// Clear fields.
				_.each(['client_id', 'from_email', 'from_name', 'html', 'markdown', 'subject', 'text', 'to_email', 'to_name'], function(field){
						self.message[field] = null;
					}
				);
				self.message.priority = 3;
				self.contentError     = true;

				// Reset Validation.
				_.each(['client_id', 'from_email', 'from_name', 'subject', 'to_email', 'to_name'], function(field){
						self.$refs[field].resetValidation();
					}
				);

			},
			sendMessage()
			{
				var self          = this;
				this.contentError = true;

				// Validate
				if ( !this.messageIsValid() ) {
					this.$q.notify({
						position : 'top',
						color    : 'negative',
						message  : 'Validation failed, please check your message\'s details and try again.'
					})
					return;
				}

				// Send Message.
				self.sending = true;
				axios.post('/api/queue-mail', {
					client_id  : _.get(this, 'message.client_id'),
					from_email : _.get(this, 'message.from_email', ''),
					from_name  : _.get(this, 'message.from_name', ''),
					html       : _.get(this, 'message.html', ''),
					markdown   : _.get(this, 'message.markdown', ''),
					priority   : _.get(this, 'message.priority', 3),
					subject    : _.get(this, 'message.subject', ''),
					text       : _.get(this, 'message.text', ''),
					to_email   : _.get(this, 'message.to_email', ''),
					to_name    : _.get(this, 'message.to_name', '')
				}).then(function(response){
					self.sending = false;
					if ( _.has(response, 'data.status') && _.isEqual(response.data.status, 'success') ) {
						self.$q.notify({
							position : 'top',
							color    : 'positive',
							message  : 'Your message has been queued for delivery via our distribution network.'
						});
						return;
					}
				})
					.catch(function(error){
						self.sending = false;
						console.log('ERR', error);
					});

			},
			updateHtmlAndText()
			{
				this.contentError = false;
				const html        = this.$refs.tuiEditor.invoke('getHtml') || "";
				const temp        = document.createElement("div");
				temp.innerHTML    = html.replace(/[<]br[^>]*[>]/gi, "\\n");
				this.message.html = html;
				this.message.text = temp.textContent || temp.innerText || "";
			}
		},
		mounted()
		{
			console.log('Create Email Mounted ..');
		}
	}
</script>

