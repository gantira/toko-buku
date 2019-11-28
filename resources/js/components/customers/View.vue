<template>
    <div class="d-flex justify-content-between" v-if="customer">
        <div class="pr-3 text-center">

            <img :src="url ? url : '/storage/' + customer.image " width="150px" class="rounded">
            <div class=" pt-2" v-if="!edit">
                <label for="file" class="font-weight-bold" style="cursor: pointer;"><mark>Select a file</mark></label>
                <input type="file" class="upload" id="file" @change="onImageChange">
                <div v-if="errors.image" class="text-danger">{{ errors.image[0] }}</div>
            </div>
        </div>
        <div class="table overflow-auto">
            <form @submit.prevent="update">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ customer.id }} <a href="#!" class="fa fa-edit" @click="toggleEdit" title="edit"
                                v-if="edit"></a></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td v-if="edit">{{ customer.name }}</td>
                        <td v-else>
                            <input type="text" v-model="customer.name" class="form-control">
                            <div v-if="errors.name" class="text-danger">{{ errors.name[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td v-if="edit">{{ customer.gender }}</td>
                        <td v-else>
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" v-model="customer.gender" value="Laki-Laki" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline1">Laki-Laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" v-model="customer.gender" value="Perempuan" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
                            </div>
                            <div v-if="errors.gender" class="text-danger">{{ errors.gender[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td v-if="edit">{{ customer.type }}</td>
                        <td v-else>
                            <select class="custom-select mr-sm-2" v-model="customer.type">
                                <option selected disabled>Choose...</option>
                                <option value="Guru">Guru</option>
                                <option value="Murid">Murid</option>
                                <option value="Umum">Umum</option>
                            </select>
                            <div v-if="errors.type" class="text-danger">{{ errors.type[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td v-if="edit">{{ customer.email }}</td>
                        <td v-else>
                            <input type="text" v-model="customer.email" class="form-control">
                            <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td v-if="edit">{{ customer.website }}</td>
                        <td v-else>
                            <input type="text" v-model="customer.website" class="form-control">
                            <div v-if="errors.website" class="text-danger">{{ errors.website[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td v-if="edit">{{ customer.phone }}</td>
                        <td v-else>
                            <input type="text" v-model="customer.phone" class="form-control">
                            <div v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Barcode</th>
                        <td>
                            <barcode :value="customer.id" :options="{ displayValue: false, height: 25 }"></barcode>
                        </td>
                    </tr>
                </table>
                <router-link to="/customers" v-if="edit">Back to all customers</router-link>
                <div v-else class="d-flex justify-content-between">
                    <div>
                        <button v-if="!loading" type="submit" class="btn btn-primary">Save</button>
                        <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button class="btn btn-outline-secondary" @click.prevent="toggleEdit">Cancel</button>
                    </div>
                    <div>
                        <button v-if="!loading" class="btn btn-outline-danger" @click.prevent="destroy">Delete</button>
                        <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'view',
        created() {
            if (this.customers.length) {
                this.customer = this.customers.find((customer) => customer.id == this.$route.params.id)
            } else {
                axios.get(`/api/customers/${this.$route.params.id}`)
                    .then((response) => {
                        this.customer = response.data.customer;
                    })
            }

        },
        data() {
            return {
                customer: {
                    id: '',
                    name: '',
                    gender: '',
                    type: '',
                    email: '',
                    phone: '',
                    website: '',
                    image: '',
                },
                edit: true,
                errors: [],
                url: false,
                loading: false,
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            customers() {
                return this.$store.getters.customers;
            }
        },
        methods: {
            toggleEdit() {
                this.edit = !this.edit
            },
            onImageChange(e) {
                const file = e.target.files[0];
                this.customer.image = file;

                console.log(file);
                this.url = URL.createObjectURL(file);
            },
            update() {
                this.loading = true
                let formData = new FormData();
                formData.append('name', this.customer.name);
                formData.append('gender', this.customer.gender);
                formData.append('type', this.customer.type);
                formData.append('email', this.customer.email);
                formData.append('phone', this.customer.phone);
                formData.append('website', this.customer.website);
                formData.append('image', this.customer.image);

                formData.append('_method', 'patch');

                axios.post(`/api/customers/${this.$route.params.id}/update`, formData)
                    .then((response) => {
                        this.customer = response.data.customer;
                        this.$store.dispatch('getCustomers');
                        this.edit = true
                        this.loading = false
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors;
                    });
            },
            destroy() {
                var conf = confirm('Yakin hapus '+ this.customer.name + ' ?')
                this.loading = true

                if (conf) {

                    axios.delete(`/api/customers/${this.$route.params.id}`)
                    .then((response) => {
                        this.customer = response.data.customer;
                        this.$router.push('/customers')
                        this.customers.splice(`${this.$route.params.id}`, 1);
                        this.loading = false
                        this.edit = true
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors;
                    });

                } else
                this.loading = false



            }

        }
    }

</script>

<style scoped>
    .upload {
        z-index: -2;
        position: absolute;
    }

</style>
