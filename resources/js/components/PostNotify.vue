<template>
    <div class="card-body" v-if="notifications">
        <div class="alert alert-info alert-dismissible fade show" id='redAlert' role="alert"
             v-for="notify in notifications" :key="notify">
            <strong>{{ notify.data.user_name }}</strong> Liked your post <b>{{ notify.data.post_title }}</b>
        </div>
    </div>
</template>

<script>
import {ref, onMounted} from 'vue';

export default {
    props: ['user', 'user_notifications'],
    async setup(props) {
        let users = ref([])
        let notifications = ref([])
        onMounted(() => {
            notifications.value = props.user_notifications
        })

        Echo.private('App.Models.User.'+ props.user.id)
            .notification((notification) => {
                notifications.value.push(notification.notification);
                // console.log(notification.notification.data);
                swal({
                    title: "Like!",
                    text: `Username: ${notification.notification.data.user_name} - Like Post:  ${notification.notification.data.post_title}`,
                    imageUrl: 'http://i.imgur.com/4NZ6uLY.jpg'
                });
            })

        return {
            notifications
        }
    }
}
</script>
