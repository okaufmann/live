<template>
    <div class="panel panel-default">
        <div class="panel-heading">Global Events</div>

        <div class="panel-body">
            <p class="lead">Events</p>
            <p>
                Send events to all clients by visit <a href="/event" class="href">/event</a>
            </p>
            <ul>
                <li v-for="event in events">{{event.message}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: [],
            }
        },
        mounted() {
            Echo.channel('messages')
                .listen('HelloEvent', (e) => {
                    console.log(e);
                    this.events.push(e);
                });
        }
    }
</script>
