<template>
    <div class="vueUserView mt-4">
        <div class="row justify-content-center">
            <div class="centeredBox col-md-5 centered">
                <div class="text-center margin bottom-md">
                    <img class="logo" src="~vue_root/images/logo.svg"/>
                </div>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<style lang="scss" src="./_user.scss" scoped></style>
