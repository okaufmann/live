<template>
    <div class="panel panel-default">
        <div class="panel-heading">Server Status</div>

        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt>Subscriptions</dt>
                <dd>{{status.subscription_count}}</dd>
                <dt>Uptime</dt>
                <dd>{{status.uptime}}</dd>
                <dt>Memory</dt>
                <dd>{{memoryUsage}}</dd>
            </dl>
        </div>
    </div>
</template>

<script>
    // https://github.com/nodejs/node-v0.x-archive/issues/8938
    var unit = ['', 'K', 'M', 'G', 'T', 'P'];

    function bytesToSize(input, precision) {
        var index = Math.floor(Math.log(input) / Math.log(1024));
        if (unit >= unit.length) return input + ' B';
        return (input / Math.pow(1024, index)).toFixed(precision) + ' ' + unit[index] + 'B'
    }

    export default {
        data() {
            return {
                status: {},
            }
        },
        mounted() {
            this.serverStatus();
        },
        methods: {
            serverStatus: function () {
                this.echoRequest('status').then((data) => {
                    this.status = data;
                    setTimeout(this.serverStatus, 2000);
                });
            },
            echoRequest: function (url) {
                let host = window.Laravel.wsHost
                let port = window.Laravel.wsPort ? ':' + window.Laravel.wsPort : "";
                let protocol = window.Laravel.wsEncrypted ? 'https' : 'http';
                let appId = window.Laravel.echoAppId;
                let appKey = window.Laravel.echoAppKey;
                url = protocol + "://" + host + port + "/apps/" + appId + "/" + url + "?auth_key=" + appKey;

                console.log("get data from echo server api ", url);
                return $.get(url);
            }
        },
        computed: {
            memoryUsage() {
                if (!this.status.memory_usage) {
                    return "";
                }

                let m = this.status.memory_usage;
                let rss = bytesToSize(m.rss, 3);
                let heap = bytesToSize(m.heapUsed, 3);
                let total = bytesToSize(m.heapTotal, 3);

                let usage = "total: " + total + " (Rss: " + rss + " / Heap: " + heap + ")";
                return usage;
            }
        }
    }
</script>
