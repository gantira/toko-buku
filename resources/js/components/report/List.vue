<template>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <th>Transaction Date</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Total</th>
            </thead>
            <tbody>
                <template>
                    <tr v-if="!transactions.length">
                        <td colspan="6" class="text-center">No Transactions Available</td>
                    </tr>
                </template>
                <template>
                    <tr v-for="(transaction, index) in transactions" :key="index">
                        <td>{{ transaction.created_at }}</td>
                        <td>{{ transaction.customer.name || '' }}</td>
                        <td>{{ transaction.customer.type || '' }}</td>
                        <td>{{ totalQty(transaction.transaction_detail) }} item(s)</td>
                        <td>{{ transaction.total | money }}</td>
                    </tr>
                </template>
            </tbody>

            <!-- <tfoot>
                <tr>
                    <td colspan="5" class="text-center font-weight-bold">TOTAL</td>
                    <td><strong></strong> {{ total | money}}</td>
                </tr>
            </tfoot> -->
        </table>

    </div>
</template>

<script>
    export default {
        name: 'list',
        data() {
            return {
                total: 0
            }
        },
        mounted() {
            if (!this.transactions.length) {
                this.$store.dispatch('getTransactions');
            }
        },
        methods: {
            totalQty(value) {
                return value.reduce(function(qty, item){
                    return qty + parseFloat(item.qty);
                },0);
            }
        },
        computed: {
            transactions() {
                return this.$store.getters.transactions;
            },
            isLoading() {
                return this.$store.getters.isLoading;
            },
        },
    }

</script>

<style>
    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }

</style>
