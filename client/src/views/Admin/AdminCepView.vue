<template>
	<v-card elevation="0">
		<v-card-title>Gerenciar CEPs</v-card-title>
		<v-card-text>
			<list-cep />
		</v-card-text>
	</v-card>
</template>

<script>
import ListCep from '@/components/lists/ListCep'

export default {
	name: "AdminCepView",

	components: {
		ListCep
	},
	created () {
		if (!this.$user) {
			this.$snotify.error('Você precisa estar autenticado para fazer isto')
			this.$router.push('/')
		}
	}
}
</script>

<style scoped>

</style>
