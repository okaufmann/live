<template>
    <div class="panel panel-default">
        <div class="panel-heading">Global Events</div>

        <div class="panel-body">
            <p class="lead">Events</p>
            <p>
                Send events to all connected clients by visit <a href="/event" class="href">/event</a>
            </p>
            <b>Last {{events.length}} Events:</b>
            <ul>
                <li v-for="event in events">{{event.message}}
                    <span>(<timeago :since="event.date" :auto-update="60"></timeago>)</span>
                </li>
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
                    let events = this.events;
                    events.push(e);

                    //ensure at least 100 events.
                    events = _.reverse(events);
                    events = _.take(events, 100);
                    events = _.reverse(events);

                    this.events = events;

                });
        }
    }
</script>
