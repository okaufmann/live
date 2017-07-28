<template>
    <div><p class="lead">See who is here:</p>

        <ul>
            <li v-for="user in users">{{user.name}}</li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">Chat, Hello {{me.name}}</div>

            <div class="panel-body chat-content">
                <ul class="chat">
                    <template v-for="message in messages">
                        <li class="left clearfix" v-if="message.user.id !== me.id">
                            <span class="chat-img pull-left">
                                <img src="https://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar"
                                     class="img-circle"/>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{message.user.name}}</strong>
                                    <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>
                                        <timeago :since="message.date" :auto-update="60"></timeago>
                                    </small>
                                </div>
                                <p>
                                    {{message.message}}
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix" v-if="message.user.id === me.id">
                            <span class="chat-img pull-right">
                                <img src="https://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar"
                                     class="img-circle"/>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span
                                            class="glyphicon glyphicon-time"></span>
                                        <timeago :since="message.date" :auto-update="60"></timeago>
                                    </small>
                                    <strong class="pull-right primary-font">{{message.user.name}}</strong>
                                </div>
                                <p>
                                    {{message.message}}
                                </p>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" v-model="chatText" @keyup.enter="sendMessage()" class="form-control input-sm"
                           placeholder="Type your message here..."/>
                    <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat" @click="sendMessage()">Send</button>
                        </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                me: window.Laravel.user,
                users: [],
                messages: [],
                chatText: [],
            }
        },
        mounted() {
            Echo.join(`chat`)
                .here((users) => {
                    this.users = _.reject(users, user => user.id === this.me.id);
                })
                .joining((user) => {
                    console.log("Joined us", user.name);
                    this.users.push(user);
                })
                .leaving((user) => {
                    console.log("Left us", user.name);
                    let users = this.users;
                    users = _.reject(users, (u) => {
                        return u.id === user.id;
                    });
                    this.users = users;
                })
                .listen('NewMessage', (e) => {
                    console.log(e);
                    this.messages.push(e);
                });
            ;
        },
        methods: {
            sendMessage() {
                console.log("send message", this.chatText);

                axios.post('/api/send', {message: this.chatText}).then((result) => {
                    this.chatText = "";
                });
            }
        }
    }
</script>

<style>
    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .chat-content {
        min-height: 400px;
    }

    .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
    }

    .chat li.left .chat-body {
        margin-left: 60px;
    }

    .chat li.right .chat-body {
        margin-right: 60px;
    }

    .chat li .chat-body p {
        margin: 0;
        color: #777777;
    }

    .panel .slidedown .glyphicon, .chat .glyphicon {
        margin-right: 5px;
    }

    .panel-body {
        /*overflow-y: scroll;*/
        /*height: 250px;*/
    }

    /*::-webkit-scrollbar-track {*/
    /*-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);*/
    /*background-color: #F5F5F5;*/
    /*}*/

    /*::-webkit-scrollbar {*/
    /*width: 12px;*/
    /*background-color: #F5F5F5;*/
    /*}*/

    /*::-webkit-scrollbar-thumb {*/
    /*-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);*/
    /*background-color: #555;*/
    /*}*/

</style>
