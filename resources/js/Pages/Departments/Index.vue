<template>
	<app-layout>

		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Отделы
			</h2>
			<div class="ml-auto">
				<button
					v-on:click="create(create_url)"
					class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
				>Новый
				</button>
			</div>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					<departments/>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
  import AppLayout from './../../Layouts/AppLayout'
  import Departments from './List/DepartmentList'

  export default {
    components: {
      AppLayout,
      Departments,
    },
    data:function(){
      return {

      }
    },
    props:{
      create_url:String
    },
    methods:{
      create(url){

        this.$inertia.visit(url, {
          method: 'get',
          data: {},
          replace: false,
          preserveState: false,
          preserveScroll: false,
          only: [],
          headers: {},
        })
      }
    },
    mounted () {

    }
  }
</script>
