<template>
    <div class="panel panel-default">
        <div class="panel-heading">Server Status</div>

        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt>Subscriptions</dt>
                <dd>.{{status.subscription_count}}</dd>
                <dt>Uptime</dt>
                <dd>.{{status.uptime}}</dd>
                <dt>Memory</dt>
                <dd>.{{memoryUsage}}</dd>
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
                    console.log(data.data);
                    let status = data.data;
                    this.status = status;
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

                // create custom instance to be modified.
                let ax = axios.create();
                // remove bearer token since, express will try to login otherwise...
                delete ax.defaults.headers.common['Authorization'];
                return ax.get(url);
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

                let usage = rss + " (Rss); Heap: " + heap + ", of total: " + total;
                return usage;
            }
        }
    }
</script>
