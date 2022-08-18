<template>
	<v-dialog
			v-model="dialog"
			persistent
			max-width="40%"
	>
		<template v-slot:activator="{ on, attrs }">
			<v-list-item
					link
					v-bind="attrs"
					v-on="on"
			>
				<v-list-item-content>
					<v-list-item-title>
						Registrar-se
					</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</template>
		<v-card>
			<v-card-title>
				<span class="text-h5">Registrar-se</span>
			</v-card-title>
			<v-card-text>
				<v-form v-on:submit="validate" ref="form" id="formData" v-model="valid" lazy-validation>
					<v-text-field
							v-model="name"
							:rules="nameRules"
							label="Nome"
							required
					></v-text-field>

					<v-text-field
							v-model="email"
							:rules="emailRules"
							label="E-mail"
							required
					></v-text-field>

					<v-text-field
							v-model="password"
							:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
							:rules="passwordRules"
							:type="showPassword ? 'text' : 'password'"
							label="Senha de acesso"
							@click:append="showPassword = !showPassword"
					></v-text-field>

					<v-text-field
							v-model="password_confirmation"
							:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
							:rules="passwordRules"
							:type="showPassword ? 'text' : 'password'"
							label="Confirme a senha de acesso"
							@click:append="showPassword = !showPassword"
					></v-text-field>
				</v-form>
			</v-card-text>
			<v-card-actions>
				<v-btn
						color="error"
						@click="dialog = false"
				>
					Fechar
				</v-btn>
				<v-spacer></v-spacer>
				<v-btn
						color="success"
						@click="validate"
						:disabled="!valid"
				>
					Checar
				</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
export default {
	name: "Register",

	data: () => ({
		dialog: false,
		valid: false,
		name: '',
		nameRules: [
			v => !!v || 'Nome deve ser preenchido',
		],
		email: '',
		emailRules: [
			v => !!v || 'Email deve ser preenchido',
			v => /.+@.+/.test(v) || 'Email inválido',
		],
		showPassword: false,
		password: '',
		password_confirmation: '',
		passwordRules: [
			v => !!v || 'Senha deve ser preenchida',
		],
	}),
	methods: {
		validate (e) {
			e.preventDefault()
			this.valid = false
			if (this.$refs.form.validate()) {
				this.$http.post(this.$urlAPI + 'users/register', {
					name: this.name,
					email: this.email,
					password: this.password,
					password_confirmation: this.password_confirmation
				}, {
					'headers': {
						'Content-type': 'application/json',
						'Accept': 'application/json',
					}
				}).then(response => {
					if (!('message' in response.data)) {
						this.$user = response.data
						localStorage.setItem('userData', JSON.stringify(response.data))
						this.$snotify.success('Registrado com sucesso!')
						this.dialog = false
						setTimeout(() => {
							this.$router.go()
						}, 1500)
					} else {
						this.$snotify.error(response.data.message)
					}
					this.valid = true
				}).catch(err => {
					if (parseInt(err.response.status) === 422) {
						let errors = err.response.data.errors
						Object.entries(errors).forEach(([key, value]) => this.$snotify.error(value[0]))
					} else {
						this.$snotify.error('Erro interno! Tente novamente mais tarde')
					}
					this.valid = true
				})
			} else {
				this.$snotify.error('Favor, verifique os campos do formulário!')
				this.valid = true
			}
		}
	},
}
</script>

<style>

</style>
