<script>

    export default {

        route: {
            activate: function(transition) {
                this.$dispatch('clearUserDetails');

            }
        }
    }
</script>