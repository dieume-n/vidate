<template>
    <div>
        <div class="mt-0 d-flex justify-content-between">
            <div>{{ subscribers}} {{ 'subscriber' | pluralize(subscribers)}}</div>
            <div class="mt-n4 pt-n2">
                <button
                    class="btn btn-danger"
                    type="button"
                    @click.prevent="handle"
                    v-if="canSubscribe"
                >{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["channelSlug"],
    data() {
        return {
            subscribers: null,
            userSubscribed: false,
            canSubscribe: false
        };
    },
    methods: {
        handle() {
            if (!this.$root.user.authenticated) {
                console.log("not authentica");
                window.location.href = `${this.$root.url}/login`;
                return;
            }

            if (this.userSubscribed) {
                this.unsubscribe();
            } else {
                this.subscribe();
            }
        },
        subscribe() {
            axios.post(`/subscriptions/${this.channelSlug}`).then(response => {
                this.userSubscribed = true;
                this.subscribers++;
            });
        },
        unsubscribe() {
            axios
                .delete(`/subscriptions/${this.channelSlug}`)
                .then(response => {
                    this.userSubscribed = false;
                    this.subscribers--;
                });
        },

        getSubscriptionStatus() {
            axios.get(`/subscriptions/${this.channelSlug}`).then(response => {
                this.subscribers = response.data.data.count;
                this.userSubscribed = response.data.data.user_subscribed;
                this.canSubscribe = response.data.data.can_subscribe;
            });
        }
    },
    mounted() {
        this.getSubscriptionStatus();
    }
};
</script>