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
						label="Busque por um CEP"
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
							Novo CEP
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
										v-model="editedItem.numero"
										:rules="numeroRules"
										v-mask="numeroMask"
										label="CEP"
										:disabled="editedIndex > -1"
										@keydown.enter.prevent="findCep"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.cep"
										:rules="cepRules"
										v-mask="cepMask"
										:disabled="editedIndex > -1"
										label="CEP Formatado"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.logradouro"
										label="Logradouro"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.complemento"
										label="Complemento"
										required
								></v-text-field>

								<v-text-field
										v-model="editedItem.bairro"
										label="Bairro"
										required
								></v-text-field>

								<v-row>
									<v-col cols="10">
										<v-text-field
												v-model="editedItem.localidade"
												:rules="localidadeRules"
												label="Localidade"
												required
										></v-text-field>
									</v-col>
									<v-col>
										<v-text-field
												v-model="editedItem.uf"
												:rules="ufRules"
												v-mask="ufMask"
												label="UF"
												required
										></v-text-field>
									</v-col>
								</v-row>

								<v-text-field
										v-model="editedItem.ddd"
										:rules="dddRules"
										v-mask="dddMask"
										label="DDD"
										required
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
						<v-card-title class="text-h5 text-center">Tem certeza que deseja deletar este CEP?</v-card-title>
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
			Nenhum CEP encontrado
		</template>
	</v-data-table>
</template>

<script>
export default {
	name: "ListCep",

	data: () => ({
		dialog: false,
		dialogDelete: false,
		headers: [
			{
				text: 'ID',
				align: 'start',
				value: 'id',
			},
			{ text: 'CEP', value: 'numero' },
			{ text: 'CEP Formatado', value: 'cep' },
			{ text: 'Logradouro', value: 'logradouro' },
			{ text: 'Complemento', value: 'complemento' },
			{ text: 'Bairro', value: 'bairro' },
			{ text: 'Localidade', value: 'localidade' },
			{ text: 'UF', value: 'uf' },
			{ text: 'DDD', value: 'ddd' },
			{ text: 'Ações', value: 'actions', sortable: false },
		],
		items: [],
		search: '',
		valid: false,
		numeroMask: '########',
		numeroRules: [
			v => !!v || 'CEP deve ser preenchido',
		],
		cepMask: '#####-###',
		cepRules: [
			v => !!v || 'CEP Formatado deve ser preenchido',
		],
		localidadeRules: [
			v => !!v || 'CEP deve ser preenchido',
		],
		ufMask: 'AA',
		ufRules: [
			v => !!v || 'UF deve ser preenchido',
		],
		dddMask: '##',
		dddRules: [
			v => !!v || 'DDD deve ser preenchido',
		],
		editedIndex: -1,
		editedItem: {
			id: 0,
			numero: '',
			cep: '',
			logradouro: '',
			complemento: '',
			bairro: '',
			localidade: '',
			uf: '',
			ddd: '',
			_method: ''
		},
		defaultItem: {
			id: 0,
			numero: '',
			cep: '',
			logradouro: '',
			complemento: '',
			bairro: '',
			localidade: '',
			uf: '',
			ddd: '',
			_method: ''
		},
	}),
	computed: {
		formTitle () {
			return this.editedIndex === -1 ? 'Novo CEP' : 'Editando CEP'
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
				url: this.$urlAPI + 'ceps/admin',
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

		findCep: function () {
			this.$http.get(this.$urlAPI + 'ceps/find/' + this.editedItem.numero)
					.then(response => {
						if (this.editedItem.numero.length === 8) {
							this.editedItem.cep = response.data.cep
							this.editedItem.logradouro = response.data.logradouro
							this.editedItem.complemento = response.data.complemento
							this.editedItem.bairro = response.data.bairro
							this.editedItem.localidade = response.data.localidade
							this.editedItem.uf = response.data.uf
							this.editedItem.ddd = response.data.ddd
						} else {
							this.$snotify.error('CEP informado é inválido')
						}
					})
					.catch(err => {
						this.$snotify.error('CEP informado é inválido')
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
				url: this.$urlAPI + 'ceps/admin/' + this.editedItem.id,
				headers: {'Authorization': 'Bearer ' + this.$user.token}
			}).then(response => {
				if (Array.isArray(response.data)) {
					this.$snotify.error(response.data.message)
				} else {
					this.$snotify.success('CEP deletado com sucesso!')
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
				this.$http.post(this.$urlAPI + 'ceps/admin/' + this.editedItem.id, this.editedItem, {
					'headers': {
						'Content-type': 'application/json',
						'Accept': 'application/json',
						'Authorization': 'Bearer ' + this.$user.token
					}
				}).then(response => {
					if (Array.isArray(response.data)) {
						this.$snotify.error(response.data.message)
					} else {
						this.$snotify.success('CEP editado com sucesso!')
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
				this.$http.post(this.$urlAPI + 'ceps/admin', this.editedItem, {
					'headers': {
						'Content-type': 'application/json',
						'Accept': 'application/json',
						'Authorization': 'Bearer ' + this.$user.token
					}
				}).then(response => {
					if (Array.isArray(response.data)) {
						this.$snotify.error(response.data.message)
					} else {
						this.$snotify.success('CEP criado com sucesso!')
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
