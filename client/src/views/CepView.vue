<template>
	<v-card elevation="0">
		<v-card-title>Resultados para a busca: {{ this.$route.params.search }}</v-card-title>

		<v-card-text v-if="data !== ''">
			<div v-if="data.length > 1">
				<div v-for="cep in filteredList">
					<h4 class="font-weight-regular"> Logradouro: <b>{{ cep.logradouro }}</b> </h4>
					<h4 class="font-weight-regular"> Complemento: <b>{{ cep.complemento }}</b> </h4>
					<h4 class="font-weight-regular"> Bairro: <b>{{ cep.bairro }}</b> </h4>
					<h4 class="font-weight-regular"> Localidade: <b>{{ cep.localidade }}</b> </h4>
					<h4 class="font-weight-regular"> UF: <b>{{ cep.uf }}</b> </h4>
					<h4 class="font-weight-regular"> DDD: <b>{{ cep.ddd }}</b> </h4>
					<v-divider class="mt-3 mb-3"></v-divider>
				</div>
				<div class="text-center">
					<v-pagination
							v-model="currentPage"
							:length="total"
							circle
					></v-pagination>
				</div>
			</div>
			<div v-else>
				<h4 class="font-weight-regular"> Logradouro: <b>{{ this.data.logradouro }}</b> </h4>
				<h4 class="font-weight-regular"> Complemento: <b>{{ this.data.complemento }}</b> </h4>
				<h4 class="font-weight-regular"> Bairro: <b>{{ this.data.bairro }}</b> </h4>
				<h4 class="font-weight-regular"> Localidade: <b>{{ this.data.localidade }}</b> </h4>
				<h4 class="font-weight-regular"> UF: <b>{{ this.data.uf }}</b> </h4>
				<h4 class="font-weight-regular"> DDD: <b>{{ this.data.ddd }}</b> </h4>
			</div>
		</v-card-text>

		<v-card-text v-else class="text-center">
			<v-progress-circular
					:size="70"
					:width="7"
					indeterminate
			></v-progress-circular>
			<h4 class="mt-4">Carregando...</h4>
		</v-card-text>
	</v-card>
</template>

<script>
export default {
	name: "CepView",

	data: () => ({
		data: '',
		maskCep: '#####-###',
		pageSize: 5,
		currentPage: 1,
		total: 0,
	}),
	created () {
		if (!this.$route.params.search) {
			this.$snotify.error('Entrada inválida!');
			this.$router.push('/')
		}

		let search = this.$route.params.search
		if (search.split(',').length === 3) {
			this.$http.get(this.$urlAPI + 'enderecos/find/' + this.$route.params.search)
					.then(response => {
						this.data = response.data
						this.total = Math.round((response.data.length / this.pageSize) + 0.4)
					})
					.catch(err => {
						console.log(err)
					})
		} else {
			this.$http.get(this.$urlAPI + 'ceps/find/' + this.$route.params.search)
					.then(response => {
						this.data = response.data
					})
					.catch(err => {
						console.log(err)
					})
		}
	},
	computed: {
		filteredList: function () {
			return this.data.filter((row, index) => {
				let start = (this.currentPage-1)*this.pageSize;
				let end = this.currentPage*this.pageSize;
				if(index >= start && index < end) return true;
			});
		},
	}
}
</script>

<style scoped>

</style>
