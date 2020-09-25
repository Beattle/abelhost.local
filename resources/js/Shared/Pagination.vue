<template>
	<div class="m-6 flex flex-wrap">
		<template v-for="(link, key) in links">
			<div
				v-if="link.url === null"
				:key="key"
				class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400"
				:class="{  }"
			>{{ link.label }}
			</div>
			<inertia-link
				v-else
				:key="key"
				class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-green-100 focus:border-indigo-500 focus:text-indigo-500"
				:class="{ 'bg-green-300': link.active }"
				:href="link.url"
				preserve-scroll
			>{{ link.label }}
			</inertia-link>
		</template>
	</div>
</template>

<script>
  export default {
    props: {
      links: Array,
    },
  }
</script>
