<template>
	<v-card elevation="0">
		<v-card-title>Gerenciar usuários</v-card-title>
		<v-card-text>
			<list-user />
		</v-card-text>
	</v-card>
</template>

<script>
import ListUser from '@/components/lists/ListUser'

export default {
	name: "AdminUserView",

	components: {
		ListUser,
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
