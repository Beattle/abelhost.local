<template>
	<div class="">
		<div
			class="bg-opacity-25 grid grid-cols-1 md:grid-cols-4"
			v-for="department in this.$page.departments"
		>
			<div class="m-4 ">
				<img class="p-2 border rounded" :alt=department.name :src="`logo/${department.logo}`"/>
			</div>
			<div class="m-4">
				<p class="font-bold">{{department.name}}</p>
				<p>{{department.description}}</p>
			</div>
			<div class="m-4">
				<template v-if="department.users.length" class="">
				<h3 class="text-lg font-bold">Users</h3>
				<ol class="ml-8">
					<li v-for="(user,index) in department.users" class=""
					>{{++index}}. {{user.name}}</li>
				</ol>
				</template>
			</div>
			<div class="m-4">
				<button v-on:click="edit(department.edit_url)"
					class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
					Edit
				</button>
				<button
					class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
					v-on:click="destroy(department.delete_url)"
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

  export default {
    name: 'DepartmentList',
    components: {
      Pagination
    },
    mounted () {

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
      edit(url){
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


