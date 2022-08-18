<template>
	<div>
		<v-form
			ref="form"
			v-on:submit="validate"
			v-model="valid"
			lazy-validation
		>
			<v-radio-group
					row
					v-model="typeSearch"
					@change="search = ''"
			>
				<v-radio
						label="CEP"
						value="0"
				></v-radio>
				<v-radio
						label="Endereço"
						value="1"
				></v-radio>
			</v-radio-group>

			<div v-if="parseInt(typeSearch) === 0">
				<v-text-field
						v-model="search"
						:rules="searchRules"
						label="Digite um CEP"
						v-mask="maskCep"
						required
				></v-text-field>
			</div>
			<div v-else>
				<v-row>
					<v-col cols="5">
						<v-text-field
								v-model="logradouro"
								:rules="logradouroRules"
								label="Logradouro"
								hint="Não utilize nº de casa/apto/lote/prédio ou abreviação."
								required
						></v-text-field>
					</v-col>
					<v-col cols="5">
						<v-text-field
								v-model="localidade"
								:rules="localidadeRules"
								label="Localidade"
								required
						></v-text-field>
					</v-col>
					<v-col>
						<v-text-field
								v-model="uf"
								:rules="ufRules"
								v-mask="ufMask"
								label="UF"
								required
						></v-text-field>
					</v-col>
				</v-row>
			</div>

			<v-btn
					:disabled="!valid"
					color="success"
					class="mt-4"
					@click="validate"
			>
				Buscar
			</v-btn>
		</v-form>
	</div>
</template>

<script>
export default {
	name: "Cep",

	data: () => ({
		valid: true,
		typeSearch: '0',
		maskCep: '#####-###',
		search: '',
		searchRules: [
			v => !!v || 'Este campo deve ser preenchido'
		],
		logradouro: '',
		logradouroRules: [
			v => !!v || 'CEP deve ser preenchido',
		],
		localidade: '',
		localidadeRules: [
			v => !!v || 'CEP deve ser preenchido',
		],
		uf: '',
		ufMask: 'AA',
		ufRules: [
			v => !!v || 'UF deve ser preenchido',
		],
	}),
	methods: {
		convertCepInNumber: function (value) {
			const char = []
			this.maskCep.split('').forEach((character, i) => {
				if (character === '#') {
					char.push(value[i])
				}
			})

			return char.join('')
		},
		validate (e) {
			e.preventDefault()
			this.valid = false
			if (this.$refs.form.validate()) {
				let search = ''
				if (parseInt(this.typeSearch) === 0) {
					search = this.convertCepInNumber(this.search)
				} else {
					search = this.logradouro + ',' + this.localidade + ',' + this.uf
				}
				this.$router.push('ceps/find/' + search)
			} else {
				this.$snotify.error('Favor, verifique os campos do formulário!');
				this.valid = false
			}
		},
	}
}
</script>

<style scoped>

</style>
