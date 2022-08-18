<template>
	<v-data-table
			:headers="headers"
			:items="(items ? items : [])"
			sort-by="id"
			:search="search"
	>
		<template v-slot:top>
			<v-toolbar
					flat
			>
				<v-text-field
						v-model="search"
						append-icon="mdi-magnify"
						label="Busque por um usuário"
						single-line
						hide-details
				></v-text-field>
				<v-dialog
						v-model="dialog"
						max-width="40%"
				>
					<template v-slot:activator="{ on, attrs }">
						<v-btn
								color="primary"
								dark
								class="mb-2 ml-4"
								v-bind="attrs"
								v-on="on"
						>
							Novo usuário
						</v-btn>
					</template>
					<v-card>
						<v-card-title>
							<span class="text-h5">{{ formTitle }}</span>
						</v-card-title>

						<v-card-text>
							<v-form v-on:submit="save" ref="form" id="formData" v-model="valid" lazy-validation>
								<v-text-field
										v-if="editedIndex > -1"
										v-model="editedItem.id"
										label="ID"
										:disabled="true"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.name"
										:rules="nameRules"
										label="Nome"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.email"
										:rules="emailRules"
										label="E-mail"
										:disabled="editedIndex > -1"
										required
								></v-text-field>

								<v-select
										v-model="editedItem.permission"
										:items="[ { 'text': 'Sim', 'value': '1' }, { 'text': 'Não', 'value': '0' }  ]"
										item-text="text"
										item-value="value"
										label="Administrador"
										color="none"
										required
								></v-select>

								<v-text-field
										v-model="editedItem.password"
										:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
										:rules="(!(editedIndex > -1) ? passwordRules : [])"
										:type="showPassword ? 'text' : 'password'"
										label="Senha de acesso"
										@click:append="showPassword = !showPassword"
								></v-text-field>

								<v-text-field
										v-model="editedItem.password_confirmation"
										:append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
										:rules="(!(editedIndex > -1) ? passwordRules : [])"
										:type="showPassword ? 'text' : 'password'"
										label="Confirme a senha de acesso"
										@click:append="showPassword = !showPassword"
								></v-text-field>
							</v-form>
						</v-card-text>

						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
									color="error"
									@click="close"
							>
								Cancelar
							</v-btn>
							<v-btn
									color="success"
									@click="save"
							>
								Salvar
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
				<v-dialog v-model="dialogDelete" max-width="40%">
					<v-card>
						<v-card-title class="text-h5">Tem certeza que deseja deletar este usuário?</v-card-title>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="success" @click="closeDelete">Cancelar</v-btn>
							<v-btn color="error" @click="deleteItemConfirm">Excluir</v-btn>
							<v-spacer></v-spacer>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-toolbar>
		</template>

		<template v-slot:item.permission="{ item }">
			{{ (parseInt(item.permission) === 1 ? 'Sim' : 'Não') }}
		</template>

		<template v-slot:item.actions="{ item }">
			<v-icon
					small
					class="mr-2"
					color="warning"
					@click="editItem(item)"
			>
				mdi-pencil
			</v-icon>
			<v-icon
					small
					color="error"
					@click="deleteItem(item)"
			>
				mdi-delete
			</v-icon>
		</template>
		<template v-slot:no-data>
			Nenhum usuãrio encontrado
		</template>
	</v-data-table>
</template>

<script>
export default {
	name: "ListUser",

	data: () => ({
		dialog: false,
		dialogDelete: false,
		headers: [
			{
				text: 'ID',
				align: 'start',
				value: 'id',
			},
			{ text: 'Nome', value: 'name' },
			{ text: 'Email', value: 'email' },
			{ text: 'Administrador', value: 'permission', filtered: false },
			{ text: 'Ações', value: 'actions', sortable: false },
		],
		items: [],
		search: '',
		valid: false,
		nameRules: [
			v => !!v || 'Nome deve ser preenchido',
		],
		emailRules: [
			v => !!v || 'Email deve ser preenchido',
			v => /.+@.+/.test(v) || 'Email inválido',
		],
		showPassword: false,
		passwordRules: [
			v => !!v || 'Senha deve ser preenchida',
		],
		editedIndex: -1,
		editedItem: {
			id: 0,
			name: '',
			email: '',
			permission: '0',
			password: '',
			password_confirmation: '',
			_method: ''
		},
		defaultItem: {
			id: 0,
			name: '',
			email: '',
			permission: '0',
			password: '',
			password_confirmation: '',
			_method: ''
		},
	}),
	computed: {
		formTitle () {
			return this.editedIndex === -1 ? 'Novo usário' : 'Editando usuário'
		},
	},
	watch: {
		dialog (val) {
			val || this.close()
		},
		dialogDelete (val) {
			val || this.closeDelete()
		},
	},
	created () {
		if (this.$user) {
			this.getData()
		}
	},
	methods: {
		getData: function () {
			this.$http({
				method: 'get',
				url: this.$urlAPI + 'users/admin',
				headers: {'Authorization': 'Bearer ' + this.$user.token}
			}).then(response => {
				if (('message' in response.data)) {
					if (parseInt(response.data.statusCode) === 401) {
						this.$snotify.error('Você precisa estar autenticado para fazer isto')
						localStorage.setItem('userData', null)
						this.$user = null
						setTimeout(() => {
							this.$router.push('/')
							this.$router.go()
						}, 1500)
					} else {
						this.$snotify.error(response.data.message)
					}
				} else {
					this.items = response.data
				}
			})
		},

		editItem (item) {
			this.editedIndex = this.items.indexOf(item)
			this.editedItem = Object.assign({}, item)
			this.dialog = true
		},

		deleteItem (item) {
			this.editedIndex = this.items.indexOf(item)
			this.editedItem = Object.assign({}, item)
			this.dialogDelete = true
		},

		deleteItemConfirm () {
			this.editedItem._method = ''
			this.$http({
				method: 'delete',
				url: this.$urlAPI + 'users/admin/' + this.editedItem.id,
				headers: {'Authorization': 'Bearer ' + this.$user.token}
			}).then(response => {
				if (Array.isArray(response.data)) {
					this.$snotify.error(response.data.message)
				} else {
					this.$snotify.success('Usuário deletado com sucesso!')
					this.close()
					this.getData()
					this.closeDelete()
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
		},

		close () {
			this.dialog = false
			this.$nextTick(() => {
				this.editedItem = Object.assign({}, this.defaultItem)
				this.editedIndex = -1
			})
		},

		closeDelete () {
			this.dialogDelete = false
			this.$nextTick(() => {
				this.editedItem = Object.assign({}, this.defaultItem)
				this.editedIndex = -1
			})
		},

		save (e) {
			e.preventDefault()
			if (this.editedIndex > -1) {
				this.editedItem._method = 'PUT'
				this.$http.post(this.$urlAPI + 'users/admin/' + this.editedItem.id, this.editedItem, {
					'headers': {
						'Content-type': 'application/json',
						'Accept': 'application/json',
						'Authorization': 'Bearer ' + this.$user.token
					}
				}).then(response => {
					if (Array.isArray(response.data)) {
						this.$snotify.error(response.data.message)
					} else {
						this.$snotify.success('Usuário editado com sucesso!')
						this.close()
						this.getData()
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
				this.editedItem._method = 'POST'
				this.$http.post(this.$urlAPI + 'users/admin', this.editedItem, {
					'headers': {
						'Content-type': 'application/json',
						'Accept': 'application/json',
						'Authorization': 'Bearer ' + this.$user.token
					}
				}).then(response => {
					if (Array.isArray(response.data)) {
						this.$snotify.error(response.data.message)
					} else {
						this.$snotify.success('Usuário criado com sucesso!')
						this.close()
						this.getData()
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
			}
		},
	}
}
</script>

<style scoped>

</style>
