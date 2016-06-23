<template>

    <div class="wrapper">
        <router-view></router-view>
    </div>

</template>
<script>

    import store from './vuex/store.js'
    import{getUser,getToken,getAuthenticated} from './vuex/getters'
    import{saveUser,clearUser} from './vuex/actions'

    export default {

        vuex:{
            getters:{
                user:getUser,
                token:getToken,
                authenticated:getAuthenticated
            },

            actions:{
                saveUser,
                clearUser
            }
        },

        store:store,

        ready: function () {
            var token = localStorage.getItem('jwt-token')
            if (token !== null && token !== 'undefined') {
                var that = this
                this.$http.get('/api/v1/auth-user').then(function(response) {
                    that.saveUser(response.data);
                }, function(response) {
                    that.clearUser();
                });
            }
        },

        events:{
            saveUserDetails:function(user){
                this.saveUser(user);
            },

            clearUserDetails: function () {
                this.clearUser();
                localStorage.removeItem('jwt-token');
                if(this.$route.auth)
                    this.$router.go('/prihlasit');
            }
        }
    }
</script>
