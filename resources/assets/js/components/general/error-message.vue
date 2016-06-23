<template>
	<div class="errors">
	    <ul>
	    	{{validation}}
	     </ul>
	    	
	  </div>
	
</template>

<script>

	export default{
		props:{
			validation : {
				required:true
			}
			
		}
	}	
	
</script>

<style>
	

</style>