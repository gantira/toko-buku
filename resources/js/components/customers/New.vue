<template>
    <div class="customer-new">
        <form @submit.prevent="add">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" v-model="customer.name" class="form-control" id="name"
                        placeholder="Customer Name">
                    <div v-if="errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" v-model="customer.gender" value="Laki-Laki" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio1">Laki-Laki</label>
                    </div>
                    <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio2" v-model="customer.gender" value="Perempuan" class="custom-control-input">
                    <label class="custom-control-label" for="customRadio2">Perempuan</label>
                    </div>
                    <div v-if="errors.gender" class="text-danger">{{ errors.gender[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <select class="custom-select mr-sm-2" v-model="customer.type">
                        <option selected disabled>Choose...</option>
                        <option value="Guru">Guru</option>
                        <option value="Murid">Murid</option>
                        <option value="Umum">Umum</option>
                    </select>
                    <div v-if="errors.type" class="text-danger">{{ errors.type[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" v-model="customer.email" class="form-control" id="email"
                        placeholder="Customer Email">
                    <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="text" v-model="customer.phone" class="form-control" id="phone"
                        placeholder="Customer phone">
                    <div v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="website" class="col-sm-2 col-form-label">Website</label>
                <div class="col-sm-10">
                    <input type="text" v-model="customer.website" class="form-control" id="website"
                        placeholder="Customer Website">
                    <div v-if="errors.website" class="text-danger">{{ errors.website[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" @change="onImageChange">
                    <div>
                        <img v-if="url" :src="url" class="img-thumbnail" width="200px" />
                    </div>
                    <div v-if="errors.image" class="text-danger">{{ errors.image[0] }}</div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-between">
                <router-link to="/customers" class="">Cancel</router-link>
                <template v-if="! loading">
                    <input type="submit" value="Create" class="btn btn-primary">
                </template>
                <template v-else>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </template>
            </div>
        </form>
    </div>
</template>

<script>
    import validate from 'validate.js';

    export default {
        data() {
            return {
                customer: {
                    name: '',
                    gender: '',
                    type: '',
                    email: '',
                    phone: '',
                    website: '',
                    image: '',
                },
                errors: [],
                loading: false,
                url: false,
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        methods: {
            onImageChange(e) {
                const file = e.target.files[0];
                this.customer.image = file;

                console.log(file);
                this.url = URL.createObjectURL(file);
            },
            add() {
                this.loading = true;
                let formData = new FormData();
                formData.append('name', this.customer.name);
                formData.append('gender', this.customer.gender);
                formData.append('type', this.customer.type);
                formData.append('email', this.customer.email);
                formData.append('phone', this.customer.phone);
                formData.append('website', this.customer.website);
                formData.append('image', this.customer.image);

                axios.post('/api/customers/new', formData)
                    .then((response) => {
                        this.loading = false;
                        this.$store.dispatch('getCustomers');
                        this.$router.push('/customers');
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errors = error.response.data.errors;
                    });
            },

        }

    }

</script>
