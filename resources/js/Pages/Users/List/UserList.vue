<template>
	<div class="">
		<div
			class="mx-2 items-center border-b   grid grid-cols-1 md:grid-cols-4"
			v-for="user in $page.users"
		>
			<div class="m-4 ">
				{{user.name}}
			</div>
			<div class="m-4">
				{{user.email}}
			</div>
			<div class="m-4">
				{{user.created_at}}
			</div>
			<div class="m-4">
				<button
					v-on:click="edit(user.edit_url)"
					class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
				>
					Edit
				</button>
				<button
					class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
					v-on:click="destroy(user.delete_url)"
				>
					Delete
				</button>
			</div>
		</div>
		<pagination :links="this.$page.links"/>
	</div>
</template>

<script>
  import Pagination from './../../../Shared/Pagination'
  import Plotly from 'plotly.js-dist'
  export default {
    name: 'userList',
    components: {
      Pagination,
    },
    mounted () {
    },
    data: function () {
      return {
      }
    },
    methods: {
      destroy (url) {
        this.$inertia.delete(url, {
          replace: false,
          preserveState: false,
          preserveScroll: true,
          only: [],
          headers: {},
        })
      },
      edit (url) {
        this.$inertia.visit(url, {
          replace: false,
          preserveState: false,
          preserveScroll: false,
          only: [],
          headers: {},
        })
      }
    }
  }
</script>


