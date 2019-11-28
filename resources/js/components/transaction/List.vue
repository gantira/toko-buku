<template>
    <div class="row">
        <div class="col-md-12">

        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header"><i class="fas fa-shopping-cart"></i> Cart</div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fas fa-barcode"></i></span>
                                    </div>
                                    <input type="text" v-model="isbn" class="form-control" placeholder="Scan Item"
                                        aria-label="Scan Item" aria-describedby="basic-addon1" @keyup.enter="addItem"
                                        autofocus>
                                </div>
                            </div>
                            <div class="col">
                                <div v-if="detail.customer" class="font-weight-light">
                                    Customer: <strong class="text-danger h5"> <br> {{ detail.customer.name }}</strong>
                                    <a href="#" @click="changeCustomer">&times;</a>
                                </div>
                                <div v-else>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" v-model="customer_id" class="form-control" placeholder="Scan ID Customer" @keyup.enter="addCustomer">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-search"></i> &nbsp; Find Customer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <select class="custom-select" v-model="customer_id">
                                    <option disabled>Select customer :</option>
                                    <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                        {{ customer.name }}</option>
                                </select> -->
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="!cart.length">
                                <tr>
                                    <td colspan="4" class="text-center">No Item</td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr v-for="(item, index) in cart" :key="item.id">
                                    <td><img :src="'storage/' + item.image" :alt="item.image" style="height: auto;max-width: 50px;" class="img-fluid mr-2">
                                        {{ item.title }}</td>
                                    <td>
                                        <input v-model="item.qty" :title="'max '+ item.stock + ' item'" type="number"
                                            class="form-control" size="1" min="0" :max="item.stock" @keydown="isNumber">
                                    </td>
                                    <td>{{ item.price*item.qty | money }}</td>
                                    <td><a class="delete" @click="removeItem(index)">
                                            <button type="button" class="close" aria-label="Close" title="delete">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <section>
                <ul class="list-group h2">
                    <li class="list-group-item"><span>TOTAL</span> <span
                            class="float-right text-danger">{{ subtotal | money}}</span></li>
                </ul>
            </section>
            <section class="pt-2">
                <button class="btn btn-block btn-primary font-weight-bold" :disabled="cart.length == 0 "
                    @click="proses">Pay</button>
            </section>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="d-flex mb-3">
                            <img :src="'storage/'+detail.customer.image" height="120px" class="mr-3"
                                :alt="detail.customer.name">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mt-0 text-capitalize font-weight-bold text-info">
                                        {{ detail.customer.name}}
                                    </h5>
                                    <div class=""><strong class="text-monospace">Phone :
                                        </strong>{{ detail.customer.phone }}</div>
                                    <div class=""><strong class="text-monospace">Email :
                                        </strong>{{ detail.customer.email }}</div>
                                    <div class=""><strong class="text-monospace">Type :
                                        </strong>{{ detail.customer.type }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="cart in detail.cart" :key="cart.id">
                                            <td>{{ cart.title }} x{{ cart.qty }}</td>
                                            <td>{{ cart.price * cart.qty | money}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between font-weight-bold bg-info h4 p-2">
                                    <div>Subtotal</div>
                                    <div>{{ subTotalHarga | money }}</div>
                                </div>
                                <div class="d-flex justify-content-between font-weight-bold bg-warning h4 p-2">
                                    <div>Discount(%)</div>
                                    <div><input type="number" v-model="discount" class="border-0 text-right" min="0" max="100"></div>
                                </div>
                                <div class="d-flex justify-content-between font-weight-bold h4 p-2"
                                    style="background-color: lightcoral">
                                    <div>Total</div>
                                    <div>{{ grandTotalHarga | money }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-block btn-success" @click="store">OK!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'transaction-list',
        mounted() {
            if (!this.products.length) {
                this.$store.dispatch('getProducts');
            }

            if (!this.customers.length) {
                this.$store.dispatch('getCustomers');
            }

            $('.toast').toast('show')
        },
        data() {
            return {
                isbn: '',
                qty: 0,
                discount: 0,
                total: 0,
                subtotal: 0,
                bayar: 0,
                temp: [],
                cart: [],
                customer_id: '',
                detail: {
                    customer: '',
                    cart: [],
                },
            }
        },
        methods: {
            addItem() {
                this.temp = this.products.find((product) => product.isbn == this.isbn)
                let valid = this.cart.find((cart) => cart.isbn == this.isbn)

                if (! this.temp && ! valid ) {
                    this.isbn = ''

                    this.$bvToast.toast(`Not found`, {
                        title: 'Cart!',
                        solid: true,
                        variant: 'warning',
                        toaster: 'b-toaster-bottom-right',
                        autoHideDelay: 4000,
                        appendToast: false
                    })

                } else if (this.temp.stock == 0) {
                    this.isbn = ''

                    this.$bvToast.toast(`Stock ${this.temp.title} is empty`, {
                        title: 'Cart!',
                        solid: true,
                        variant: 'danger',
                        toaster: 'b-toaster-bottom-right',
                        autoHideDelay: 4000,
                        appendToast: false
                    })
                } else if(this.temp && ! valid && this.temp.stock != 0) {
                    this.cart.push({
                        id: this.temp.id,
                        qty: 1,
                        title: this.temp.title,
                        price: this.temp.price,
                        isbn: this.temp.isbn,
                        stock: this.temp.stock,
                        image: this.temp.image,
                    })
                    this.isbn = ''

                    this.$bvToast.toast(`${this.temp.title} added. Total ${this.cart.length} item(s)`, {
                        title: 'Cart!',
                        solid: true,
                        variant: 'success',
                        toaster: 'b-toaster-bottom-right',
                        autoHideDelay: 4000,
                        appendToast: false
                    })
                } else {
                    this.isbn = ''

                    console.log('error')
                }
            },
            addCustomer() {
                this.detail.customer = this.customers.find((customer) => customer.id == this.customer_id)

                if(!this.detail.customer) {
                    this.detail.customer = ''
                }
            },
            removeItem(index) {
                this.cart.splice(index, 1);
            },
            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode > 48 || charCode < 57)) && charCode !== 46 && charCode !== 38 &&
                    charCode !== 40) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            proses() {
                this.detail.customer = this.customers.find((customer) => customer.id == this.customer_id)
                this.detail.cart = this.cart
                $('.bd-example-modal').modal('show');
            },
            store() {
                const arr1 = [{
                    cart: this.cart
                }]
                const arr2 = [{
                    customer_id: this.customer_id,
                    discount: this.discount,
                    total: this.total,
                    subtotal: this.subtotal,
                    user_id: this.currentUser.id,
                }]
                const merg = [...arr1, ...arr2]

                axios.post('/api/transactions', merg)
                    .then((response) => {
                        $('.bd-example-modal').modal('hide');
                        alert('transaksi sukses')
                        this.cart = []
                        this.customer_id = ''
                        this.detail.customer = ''

                        this.$bvToast.toast(`Thank you.` , {
                            title: 'Transaction Success!',
                            solid: true,
                            variant: 'success',
                            toaster: 'b-toaster-top-full',
                            autoHideDelay: 4000,
                        })

                        this.$store.dispatch('getProducts');

                        window.open(window.location.origin+'/print/'+response.data.transaction.id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,width=800,height=400");

                        console.log(response.data)
                    })
                    .catch((errors) => {
                        console.log(errors.response.data.error)
                    })
            },
            changeCustomer() {
                this.detail.customer = ''
                this.customer_id = ''
            },
            toast() {
                this.$bvToast.toast(toast, {
                    title: 'Transaction Success!',
                    solid: true,
                    variant: 'success',
                    toaster: 'b-toaster-top-full',
                    autoHideDelay: 4000,
                })
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            products() {
                return this.$store.getters.products
            },
            customers() {
                return this.$store.getters.customers
            },
            subTotalHarga() {
                let sum = 0;
                this.cart.forEach(function (product) {
                    sum += (parseFloat(product.price) * parseFloat(product.qty));
                });

                this.subtotal = sum

                return this.subtotal;
            },
            grandTotalHarga() {
                this.total = this.subtotal - (this.subtotal * this.discount/100)

                return this.total
            },
            kembali() {
                return this.bayar - this.grandTotalHarga
            }

        }
    }

</script>
