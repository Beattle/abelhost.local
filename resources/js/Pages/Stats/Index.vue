<template>
	<div>
		<app-layout>
			<template #header>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					График сотрудников по отделам
				</h2>
			</template>
			<div class="py-12">
				<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
					<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
						<div :ref="id" class="graphId"></div>
					</div>

				</div>
			</div>
		</app-layout>

	</div>
</template>

<script>
	import AppLayout from '../../Layouts/AppLayout'
	import Plotly from 'plotly.js-dist'


  export default {
    components:{
       AppLayout
    },
    mounted () {
      for (let dep of this.$page.data){
        this.data[0].x[this.data[0].x.length] = dep.name
        this.data[0].y[this.data[0].y.length] = dep.users_count
      }
      Plotly.newPlot(this.$refs[this.id], this.data, this.layout, {displayModeBar: false});
    },
    data:function(){
      return {
        id:'chart',
        data: [{
          x: [],
          y:[],
          histfunc: "sum",
          type: 'histogram'
        }],
        layout: {
          title: 'Количество сотрудников в отделах'
        }
      }
    },

  }
</script>
