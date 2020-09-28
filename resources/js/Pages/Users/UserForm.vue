<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				<template v-if="$page.currentRouteName === 'users.create'">Создать</template>
				<template v-if="$page.currentRouteName === 'users.edit'">
					<span>Редактировать</span>
				</template>
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
							<label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name:</label>
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
							<label class="block text-gray-700 text-sm font-bold mb-2" for="description">E-mail:
							</label>
							<input
								v-bind:class="{'border-red-500':$page.errors.email}"
								class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
								id="description"
								v-model="form.email"
							/>
							<div class="text-red-500 text-xs italic" v-if="$page.errors.email">
								{{ $page.errors.email}}
							</div>
						</div>
						<div class="mb-6">
							<label class="block text-gray-700 text-sm font-bold mb-2" for="logo">Password:</label>

							<input
								v-bind:class="{'border-red-500':$page.errors.password}"
								type="password"
								v-model="form.password"
								class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
								id="logo"
							/>
							<div class="text-red-500 text-xs italic" v-if="$page.errors.password">{{ $page.errors.password }}
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
          name: this.$page.edit_user ? this.$page.edit_user.name : null,
          email: this.$page.edit_user ? this.$page.edit_user.email : null,
          password: '',
          id: this.$page.edit_user ? this.$page.edit_user.id : null
        },
      }
    },
    props: {},
    methods: {
      submit () {
        var data = new FormData()
        data.append('name', this.form.name || '')
        data.append('email', this.form.email || '')
        data.append('password',this.form.password)

        if (this.$page.currentRouteName === 'users.create') {
          this.create(data)
        }
        if (this.$page.currentRouteName === 'users.edit') {
          this.update(data)
        }
      },
      update (data) {
        data.append('_method', 'PUT')
        this.$inertia.post(this.route('users.update', this.form.id), data)
      },
      create (data) {
        this.$inertia.post(this.route('users.store'), data)
      },
    },
    mounted () {

    }
  }
</script>
