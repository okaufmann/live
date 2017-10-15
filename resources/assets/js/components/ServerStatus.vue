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
                this.getWsServerStatus().then((response) => {
                    this.status = response.data;
                    setTimeout(this.serverStatus, 2000);
                }).catch(() => setTimeout(this.serverStatus, 5000));
            },
            getWsServerStatus: function () {
                let url = '/api/server_status';

                return axios.get(url);
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
