<template>
    <div class="panel panel-default">
        <div class="panel-heading">Presence and Events</div>

        <div class="panel-body">
            <p class="lead">Events</p>
            <ul>
                <li v-for="event in events">{{event}}</li>
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
            console.log('Component mounted.');

            Echo.channel('messages')
                .listen('HelloEvent', (e) => {
                    console.log(e);
                    this.events.push(e);
                });
        }
    }
</script>
