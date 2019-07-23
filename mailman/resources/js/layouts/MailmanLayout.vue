<template>
				<q-layout view="hHh lpR fFf">
								<q-header class="bg-white text-grey-8 q-py-xs shadow-1">
												<q-toolbar>
																<q-btn
																								flat
																								dense
																								round
																								@click="leftDrawerOpen = !leftDrawerOpen"
																								aria-label="Menu"
																								icon="menu"
																/>

																<q-btn flat no-caps no-wrap class="q-ml-xs" to="/" v-if="$q.screen.gt.xs">
																				<q-icon name="fas fa-paper-plane" color="blue" size="28px"/>
																				<q-toolbar-title shrink class="text-weight-bold">
																								MailMan
																				</q-toolbar-title>
																</q-btn>

																<q-space/>

																<div class="YL__toolbar-input-container row no-wrap">
																				<q-input dense outlined square v-model="search" placeholder="Search" class="bg-white col"/>
																				<q-btn class="YL__toolbar-input-btn" color="grey-3" text-color="grey-8" icon="search" unelevated/>
																</div>

																<q-space/>

																<div class="q-gutter-sm row items-center no-wrap">
																				<q-btn round dense flat color="grey-8" icon="video_call" v-if="$q.screen.gt.sm">
																								<q-tooltip>Create a video or post</q-tooltip>
																				</q-btn>
																				<q-btn round dense flat color="grey-8" icon="apps" v-if="$q.screen.gt.sm">
																								<q-tooltip>Apps</q-tooltip>
																				</q-btn>
																				<q-btn round dense flat color="grey-8" icon="message" v-if="$q.screen.gt.sm">
																								<q-tooltip>Messages</q-tooltip>
																				</q-btn>
																				<q-btn round dense flat color="grey-8" icon="notifications">
																								<q-badge color="red" text-color="white" floating>
																												2
																								</q-badge>
																								<q-tooltip>Notifications</q-tooltip>
																				</q-btn>
																				<q-btn round flat>
																								<q-avatar size="26px">
																												<img src="https://cdn.quasar.dev/img/boy-avatar.png">
																								</q-avatar>
																								<q-tooltip>Account</q-tooltip>
																				</q-btn>
																</div>
												</q-toolbar>
								</q-header>

								<q-drawer
																v-model="leftDrawerOpen"
																bordered
																show-if-above
																content-class="bg-grey-2"
																:width="240"
								>
												<q-scroll-area class="fit">
																<q-list padding>

																				<q-item v-for="link in links1" :key="link.text" :to="link.location" v-ripple clickable>
																								<q-item-section avatar>
																												<q-icon color="grey" :name="link.icon"/>
																								</q-item-section>
																								<q-item-section>
																												<q-item-label class="text-capitalize">{{ link.text }}</q-item-label>
																								</q-item-section>
																				</q-item>
																				<q-separator class="q-mt-md q-mb-xs"/>

																</q-list>
												</q-scroll-area>
								</q-drawer>

								<q-page-container>
												<router-view/>
								</q-page-container>
				</q-layout>
</template>

<script>
	export default {
		name : 'MailmanLayout',
		data()
		{
			return {
				leftDrawerOpen : false,
				search         : '',
				links1         : [
					{ icon : 'fas fa-envelope', text : 'SEND A MESSAGE', location : '/create' },
					{ icon : 'fas fa-download', text : 'WEBHOOKS', location : '/webhooks' },
				]
			}
		}
	}
</script>

<style>
				.YL__toolbar-input-container {
								min-width: 100px;
								width: 55%;
				}

				.YL__toolbar-input-btn {
								border-radius: 0;
								border-style: solid;
								border-width: 1px 1px 1px 0;
								border-color: rgba(0, 0, 0, 0.24);
								max-width: 60px;
								width: 100%;
				}

				.YL__drawer-footer-link {
								color: inherit;
								text-decoration: none;
								font-weight: 500;
								font-size: 0.75rem;
				}

				.YL__drawer-footer-link:hover {
								color: #000;
				}
</style>
