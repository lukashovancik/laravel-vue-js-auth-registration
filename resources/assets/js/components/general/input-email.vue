<template>
	<input type="text" class="form-control" initial="off" id="email" v-validate:email="{ 
                  required: { rule: true, message: 'Email je povinný !!' },
                  email   : { rule: true, message: 'Nezadali ste email v správnom tvare !!'}

                }">
</template>

<script>
	export default{
		props:{
		
			
		}
	}	

</script>