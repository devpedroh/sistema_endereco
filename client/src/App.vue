<template>
	<v-app id="inspire">
		<vue-snotify></vue-snotify>
		<nav-bar />

		<v-main class="grey lighten-3">
			<v-container>
				<v-row>
					<v-col cols="2">
						<utilitary-bar />
					</v-col>

					<v-col>
						<router-view></router-view>
					</v-col>
				</v-row>
			</v-container>
		</v-main>
	</v-app>
</template>

<script>
import NavBar from '@/components/toolbar/NavBar'
import UtilitaryBar from "@/components/toolbar/UtilitaryBar";

export default {
	name: 'App',

	components: {
		NavBar,
		UtilitaryBar
	},
	data: () => ({

	}),
};
</script>

<style>
@import "~vue-snotify/styles/material.css";

</style>
