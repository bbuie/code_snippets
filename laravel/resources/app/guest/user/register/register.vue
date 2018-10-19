<template>
    <div class="vueRegisterView">

        <h3 class="text-primary">Create an account</h3>

        <div class="form-group">
            <validated-input v-model="credentials.name" :type="'text'" :name="'name'" :placeholder="'Full Name'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group">
            <validated-input v-model="credentials.email" :type="'text'" :name="'email'" :placeholder="'Email Address'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group">
            <validated-input v-model="credentials.password" :type="'password'" :name="'password'" :placeholder="'Password'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group margin bottom-lg">
            <input v-model="credentials.password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
        </div>

        <app-message :type="'error'" :messages="apiErrors" @close="apiErrors = []"></app-message>

        <div class="pull-right">
            <button class="btn btn-primary pull-right" title="Create Account at Buink" v-on:click="attemptRegisterUser(credentials)" v-show="!registeringUser">SIGNUP</button>
            <span v-show="registeringUser"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></span>
        </div>

        <router-link to="login">Login</router-link>
    </div>
</template>
<script src="./register.controller.js"></script>
