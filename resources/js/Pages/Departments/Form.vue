<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				<span v-if="$page.currentRouteName === 'departments.create'">Создать</span>
				<span v-if="$page.currentRouteName === 'departments.edit'">Редактировать</span>
			</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					<div v-if="$page.flash.message" class="flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3" role="alert">
						<p>{{$page.flash.message}}</p>
					</div>
					<form
						enctype="multipart/form-data"
						class="bg-white  rounded px-8 pt-6 pb-8 mb-4"
						@submit.prevent="submit"
					>
						<div class="mb-4">
							<label class="block text-gray-700 text-sm font-bold mb-2" for="name">Название:</label>
							<input
								v-bind:class="{'border-red-500':$page.errors.name}"
								class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
								id="name"
								v-model="form.name"
							/>
							<div class="text-red-500 text-xs italic" v-if="$page.errors.name">{{ $page.errors.name }}
							</div>
						</div>
						<div class="mb-4">
							<label class="block text-gray-700 text-sm font-bold mb-2" for="description">Описание:
							</label>
							<textarea
								v-bind:class="{'border-red-500':$page.errors.description}"
								class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
								id="description"
								v-model="form.description"
							></textarea>
							<div class="text-red-500 text-xs italic" v-if="$page.errors.description">{{
								$page.errors.description}}
							</div>
						</div>
						<div class="mb-6">
							<label class="block text-gray-700 text-sm font-bold mb-2" for="logo">Лого:</label>
							<input
								v-bind:class="{'border-red-500':$page.errors.logo}"
								type="file" multiple v-on:change="getFile($event)"
								placholder="Тестовый"
								class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
								id="logo"
							/>
							<div class="text-red-500 text-xs italic" v-if="$page.errors.logo">{{ $page.errors.logo }}
							</div>
						</div>
						<div class="mb-6">
						<header class="text-2xl ">Пользователи</header>
						<div
							class=""
							v-for="(user,index) in $page.all_users"
						>
							<input v-model="form.user_id" :value="user.id" v-bind:id="'user-id-'+index" type="checkbox"/>
							<label class="cursor-pointer" v-bind:for="'user-id-'+index">{{user.name}}</label>
							(
							<a class="text-blue-500 hover:text-blue-700" :href="'mailto:'+user.email">{{user.email}}</a>
							)
						</div>
						</div>
						<button
							class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
							type="submit"
						>Submit
						</button>
					</form>
				</div>
			</div>
		</div>
	</app-layout>

</template>

<script>
  import AppLayout from './../../Layouts/AppLayout'
  import Label from '../../Jetstream/Label'

  export default {
    name: 'Create',
    components: {
      Label,
      AppLayout,
    },
    data: function () {
      return {
        form: {
          name:  this.$page.department ? this.$page.department.name: null,
          description: this.$page.department ? this.$page.department.description: null,
          logo: this.$page.department ? this.$page.department.logo: null,
          user_id:  this.$page.user_attached || [],
          id:this.$page.department ? this.$page.department.id:null
        },
      }
    },
    props: {},
    methods: {
      submit () {
        var data = new FormData()
        data.append('name', this.form.name || '')
        data.append('description', this.form.description || '')
        if(this.form.user_id.length){
          for (let id of this.form.user_id){
            data.append('user_id[]',id)
          }

        }

        if (this.form.logo !== null && typeof this.form.logo == 'object') {
          data.append('logo', this.form.logo[0], this.form.logo[0].name)

        }
        if (this.form.logo !== null  && typeof this.form.logo == 'string') {
        //  data.append('logo', this.form.logo )
        }
		if(this.$page.currentRouteName === 'departments.create'){
		  this.create(data)
		}
        if(this.$page.currentRouteName === 'departments.edit'){
          this.update(data)
        }
      },
      update(data){
        data.append("_method", "PUT");
        this.$inertia.post(this.route('departments.update',this.form.id), data)
      },
      create(data){
        this.$inertia.post(this.route('departments.store'), data)
      },
      getFile (event) {
        let files = event.target.files || event.dataTransfer.files
        if (!files.length)
          return
        this.form.logo = files
      }
    },
    mounted () {

    }
  }
</script>
