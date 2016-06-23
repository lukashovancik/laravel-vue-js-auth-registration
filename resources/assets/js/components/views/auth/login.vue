<template>

    <div class="col-md-4">
       <validator name="validationLogin">

        <form @submit.prevent="authenticate(userLogin)"  novalidate class="sidebar-login">

            <h3>PRIHLÁSENIE</h3>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="errors" v-if="$validationLogin.email.errors">
                  <ul>
                    <li v-for="error in $validationLogin.email.errors">
                      <p>{{error.message}}</p>
                    </li>
                  </ul>
                </div>
                <input type="text" @focus="userLogin.error = false;" initial="off" class="form-control" id="email"  v-model="userLogin.email" v-validate:email="{ 
                  required: { rule: true, message: 'Email je povinný.' },
                  email   : { rule: true, message: 'Zadajte email v správnom tvare.'}
                }">
                
            </div>
            <div class="form-group">
                <label for="pwd">Heslo:</label>
                <input type="password" class="form-control" @focus="userLogin.error = false" id="pwd" v-model="userLogin.password">
            </div>
            <button type="submit" class="btn btn-success" initial="true" :disabled="!$validationLogin.valid || !userLogin.email || !userLogin.password">Prihlásiť 
              <span v-if="userLogin.loading"><img src="../icon/loading.gif" width="20" height="20" alt="loading"></span>
            </button>
            <span class="alert alert-warning" v-if="userLogin.error"> Prihlásenie nebolo úspešné :(</span>
      
        </form>

    </validator>   
    </div>


    <div class="col-md-offset-4 col-md-4">
     <validator name="validationRegister">

        <form @submit.prevent="register(userRegister)" novalidate class="sidebar-login register">
            <h3>REGISTRÁCIA</h3>
            <div class="form-group">
                <label for="username">Používateľske meno</label>
                <div class="errors" v-if="$validationRegister.username.errors">
                  <ul>
                    <li v-for="error in $validationRegister.username.errors">
                      <p>{{error.message}}</p>
                    </li>
                  </ul>
                </div>
                <input type="text" class="form-control" initial="off" @change="checkUsername(userRegister.username)" v-model="userRegister.username"  
                v-validate:username ="{
                        required: { rule: true, message: 'Používateľske meno je povinné.' },
                        minlength: { rule: 2, message: 'Používateľske meno musí mať najmenej dva znaky.' }
                        }" >
               <span v-if="checkUsr"> <small>Používateľské meno niekto používa.</small></span>         
            </div>
            <div class="form-group" >
                <label for="email">Email</label>
                 <div class="errors" v-if="$validationRegister.email.errors">
                  <ul>
                    <li v-for="error in $validationRegister.email.errors">
                      <p>{{error.message}}</p>
                    </li>
                  </ul>
                </div>
                <input type="text" class="form-control" initial="off" @change="checkEmail(userRegister.email)" v-model="userRegister.email" v-validate:email="{ 
                  required: { rule: true, message: 'Email je povinný.' },
                  email   : { rule: true, message: 'Zadajte email v správnom tvare.'}

                }">

               <span v-if="checkMail"> <small>Zadaný email už niekto používa.</small></span>         
            </div>

            <div class="form-group">
                <label for="pwd">Heslo:</label>
                <div class="errors" v-if="$validationRegister.password.errors">
                  <ul>
                    <li v-for="error in $validationRegister.password.errors">
                      <p>{{error.message}}</p>
                    </li>
                  </ul>
                </div>
                <input type="password" initial="off" class="form-control" v-model="userRegister.password"  
                v-validate:password ="{
                        required: { rule: true, message: 'Heslo je povinné.' },
                        minlength: { rule: 5, message: 'Heslo musí mať minimálne 5 znakov.' }
                  }" >
            </div>

            <div class="form-group">
                <label for="pwd">Zopakujte heslo:</label>
                <div class="errors" v-if="$validationRegister.confirm.errors">
                  <ul>
                    <li v-for="error in $validationRegister.confirm.errors">
                      <p>{{error.message}}</p>
                    </li>
                  </ul>
                </div>
                <input type="password" initial="off" class="form-control" v-model="userRegister.password_confirmed"
                 v-validate:confirm ="{
                        confirm:  { rule: userRegister.password, message: 'Hesla sa nezhodujú.' },
                        required: { rule: true, message: 'Potvrdenie hesla je povinné.' }
                  }" >

            </div>

            <div class="form-group" v-if="!userRegister.captcha">
                <span class="alert-danger">Nepotvrdené</span>
                 Potvrdte správnosť údajov doplnením správneho výsledka a správny výsledok potvrdte enterom <br>
                <input @keyup.enter="captcha(captchas.result)" placeholder="{{captchas.firstNumber}} + {{captchas.secondNumber}} = " v-model="captchas.result">
            </div>
            <div class="form-group" v-else>
                 <span class="alert-success">Potvrdené</span>
             </div>

            <button type="submit" class="btn btn-primary" :disabled="!$validationRegister.valid || !userRegister.username || !userRegister.email || !userRegister.password || !userRegister.password_confirmed || checkUsr || checkMail || !userRegister.captcha" >Registrovať
              <span v-if="userRegister.loading"><img src="../icon/loading.gif" width="20" height="20" alt="loading"></span>
            </button>
        </form>


    </validator>
  </div>
</template>

<script>
    export default{

        data: function () {
          return {

              checkUsr:false,
              checkMail:false,

              userLogin:{
                  email:null,
                  password:null,
                  error:false,
                  loading:false,
              },

              userRegister:{
                  username:null,
                  email:null,
                  password:null,
                  password_confirmed:null,
                  loading:false,
                  errorPassword:'',
                  captcha:false
              },

              captchas:{
                 firstNumber: this.getRandomInt(),
                 secondNumber: this.getRandomInt(),
                 result: null
              } 
          }
        },

        validators: {
            confirm: function (val, target) {
              return val === target
            },

            email:function (val) {
               return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(val)
            }
            
        },

        methods:{
           getRandomInt:function() {
              var min = 0,
                  max = 10;
              return Math.floor(Math.random() * (max - min)) + min;
           },

            captcha:function (val) {
               if((this.captchas.firstNumber + this.captchas.secondNumber) == val){
                  this.userRegister.captcha = true;
               } else{
                   this.userRegister.captcha = false;
               }
            },

            authenticate:function(user){
             
                this.userLogin.submitted = true;
                this.userLogin.loading = true;
                var that = this;
                console.log('udalost');    

                this.$http.post('/api/v1/authenticate',user).then(function (response) {
                   console.log(response);

                    //success
                   that.getUserData();
                   that.userLogin.loading = false;

                }, function (response) {
                    that.userLogin.error = true;
                    console.log(response);

                    //error
                   that.userLogin.loading = false;
                   console.log(response.data);
                }); 
            },

            register:function(user) {
                console.log('udalost');    
                this.userRegister.loading = true;
                var that     = this;

                this.$http.post('/api/v1/register',user).then(function (response) {
                   console.log(response);
                    //success
                   that.getUserData();
                   that.userRegister.loading = false;

                }, function (response) {
                    console.log(response);
                    //error
                    that.userRegister.loading = false;
                    console.log(response.data);
                });     
            },

            getUserData:function(){
                var that = this;

                this.$http.get('/api/v1/auth-user').then(function(response) {
                    that.$dispatch('saveUserDetails', response.data);
                    that.loading = false;
                    that.$router.go('/domov');

            })},

           checkUsername:function(username) {
             var that = this;
             this.checkUsr = false;

             this.$http.get('/api/v1/checkUserName',{username:username}).then(function (response) {
               
                if(response.data){
                    that.checkUsr = true;
                }
             },
             function (response) {
                    console.log(response);
             });  
           },

           checkEmail:function(email) {
             var that = this;
             this.checkMail = false;

             this.$http.get('/api/v1/checkEmail',{email:email}).then(function (response) {
               
                if(response.data){
                    that.checkMail = true;
                }
             },

             function (response) {
                    console.log(response);
                
             });  
           }     
        }
    }
</script>
