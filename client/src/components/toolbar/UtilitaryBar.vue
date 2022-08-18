<template>
	<v-sheet rounded="lg">
		<v-list color="transparent">
			<v-list-item to="/" link>
				<v-list-item-content>
					<v-list-item-title>
						Buscar um CEP ou Endereço
					</v-list-item-title>
				</v-list-item-content>
			</v-list-item>

			<v-divider class="my-2"></v-divider>

			<template v-if="!this.$user">
				<login-button />

				<register-button />
			</template>
			<template v-else-if="parseInt(this.$user.permission) === 1">
				<v-list-item
						link
						to="/admin/users"
				>
					<v-list-item-content>
						<v-list-item-title>
							Listar usuários
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>

				<v-list-item
						link
						to="/admin/ceps"
				>
					<v-list-item-content>
						<v-list-item-title>
							Listar CEPs
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>

				<v-list-item
						link
						@click="logout"
				>
					<v-list-item-content>
						<v-list-item-title>
							Deslogar
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</template>

			<template v-else>
				<v-list-item
						link
						@click="logout"
				>
					<v-list-item-content>
						<v-list-item-title>
							Deslogar
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</template>

		</v-list>
	</v-sheet>
</template>

<script>
import LoginButton from '@/components/toolbar/buttons/Login'
import RegisterButton from '@/components/toolbar/buttons/Register'

export default {
	name: "UtilitaryBar",

	components: {
		LoginButton,
		RegisterButton
	},
	methods: {
		logout: function () {
			this.$http.post(this.$urlAPI + 'users/logout', {}, {
				'headers': {
					'Authorization': 'Bearer ' + this.$user.token
				}
			}).then(response => {
				this.$snotify.success(response.data)
				localStorage.setItem('userData', null)
				setTimeout(() => {
					this.$router.go()
				}, 1500)
			})
		}
	}
}
</script>

<style scoped>

</style>
