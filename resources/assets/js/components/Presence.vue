<template>
    <div class="panel panel-default">
        <div class="panel-heading">Example Component</div>

        <div class="panel-body">
            <p class="lead">See whos here:</p>

            <ul>
                <li v-for="user in users">{{user.name}}</li>
            </ul>

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
                users: [],
                events: [],
            }
        },
        mounted() {
            console.log('Component mounted.')

            Echo.join(`chat`)
                .here((users) => {
                    this.users = users;
                })
                .joining((user) => {
                    console.log("Enter us", user.name);
                    this.users.push(user);
                })
                .leaving((user) => {
                    console.log("Left us", user.name);
                    let users = this.users;
                    users = _.reject(users, (u) => {
                        return u.id === user.id;
                    });

                    this.users = users;
                });

            Echo.channel('messages')
                .listen('HelloEvent', (e) => {
                    console.log(e);
                    this.events.push(e);
                });
        }
    }
</script>
