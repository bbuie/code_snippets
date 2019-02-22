<template lang="html">
    <div class="upgradeRequiredView">
        <app-header class="mt-5" />
        <b-modal
            v-model="modalOpen"
            hide-header
            hide-footer
            lazy
            centered
            no-close-on-backdrop
            no-close-on-esc
        >
            <b-container>
                <h3>New Version Available</h3>
                <div class="text-dark">
                    Please upgrade to the latest version to continue to Defend Your Money!
                </div>
            </b-container>
        </b-modal>
    </div>
</template>

<script src="./upgrade-required.controller.js"></script>
<style lang="scss" src="./_upgrade-required.scss" scoped></style>