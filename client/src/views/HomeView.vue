<template>
	<v-card>
		<v-card-title>Busca CEP</v-card-title>
		<v-card-text>
			<cep />
		</v-card-text>
	</v-card>
</template>

<script>
import Cep from '@/components/Cep'

  export default {
    name: 'Home',

		components: {
			Cep,
		},
		data: () => ({

		}),
  }
</script>
