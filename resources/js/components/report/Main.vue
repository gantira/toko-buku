<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            Report
                        </div>
                        <div>
                            <i class="fas fa-print"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'items-main',
}
</script>
