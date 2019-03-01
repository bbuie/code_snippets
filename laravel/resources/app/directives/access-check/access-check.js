/*
    <div v-dym-access="{ permission: 'permissionToCheck', behavior: 'hide/disable', valueToTest: value }"></div>
*/
import subscriptionVerificationMixin from 'vue_root/mixins/subscriptionVerification.mixin';
import store from 'vue_root/app.store';
const { verifySubscriptionStatus, verifySubscriptionPlan } = subscriptionVerificationMixin.methods;

export default {
    bind: setupDirective,
    update: setupDirective
};

function setupDirective(el, binding, vnode){
    const settings = Object.assign(defaultSettings(), binding.value);

    if(settings.permission){
        const userHasPermission = checkPermission(settings);
        if(!userHasPermission){
            removeElementAccess(el, binding, vnode, settings);
        }
    } else {
        throw new Error("The 'access' directive requires a permission to check.");
    }

    function defaultSettings(){
        return {
            permission: null, // string: 'permission'
            behavior: 'hide', // string: 'hide' | 'disable'
            valueToTest: null // string: the value that you want to test, e.g. subscriptionPlan = 'plus'
        };
    }
}

function checkPermission({ permission, valueToTest }){
    let hasPermission = false;
    if(permission === 'subscriptionPlan'){
        hasPermission = verifySubscriptionPlan(valueToTest);
    } else if(permission === 'subscriptionStatus'){
        hasPermission = verifySubscriptionStatus(valueToTest);
    } else if(permission === 'permission'){
        hasPermission = verifyPermission(valueToTest);
    }
    return hasPermission;
}

function removeElementAccess(el, binding, vnode, settings){
    const behavior = settings.behavior;

    if(behavior === 'hide'){
        commentNode();
    } else if(behavior === 'disable'){
        el.disabled = true;
    }

    function commentNode(){
        const comment = document.createComment(' ');

        Object.defineProperty(comment, 'setAttribute', { value: () => undefined });

        vnode.text = ' ';
        vnode.elm = comment;
        vnode.isComment = true;
        vnode.tag = undefined;
        vnode.data.directives = undefined;

        if(vnode.componentInstance){
            vnode.componentInstance.$el = comment;
        }

        if(el.parentNode){
            el.parentNode.replaceChild(comment, el);
        }
    }
}

function verifyPermission(permissionValue){
    const user = store.state.guest.user.user;
    return user.current_account_user.all_permission_names.includes(permissionValue);
}
