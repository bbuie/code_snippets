<!--
Usage:  <app-message
            :type="choose one: 'success', 'error'"
            :messages="array_of_messages"
            :float-right="boolean"
            @close="array_of_messages = []">
        </app-message>
-->
<template>
    <div class="app-message alert  row no-gutters"
        v-if="messages.length > 0"
        :class="{
            'float-right': floatRight,
            'ml-auto': floatRight,
            'alert-success': type === 'success',
            'alert-danger' : type === 'error'}"
        endAttributes>
        <div class="col-md-11">
            <div v-for="(message, index) in messages" v-bind:key="index">
                {{ message }}
            </div>
            <slot></slot>
        </div>
        <div class="col-md-1 text-right">
            <i class="fa fa-close close-btn" @click="$emit('close')"></i>
        </div>
    </div>
</template>
<script src="./app-message.controller.js"></script>
<style lang="scss" src="./_app-message.scss" scoped></style>
