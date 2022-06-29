<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import TextInput from '@/Components/TextInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    settings: Object,
});

const form = useForm({
    name: '',
    company_name:'',
    company_address:'',
    first_name:'',
    last_name:'',
    email: '',
    phone: '',
    lat:'',
    lng:'',
    country:'',
    search_str:'',
    postal_code:'',
    physical_address:'',
    password: '',
    password_confirmation: '',
    terms: false,
    errors:{}
});

const submit = () => {
    form.post(route('register'), {
        //onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const getSetting = (name,settings) => {
    let setting = '';
    for( let i = 0; i < settings.length; i ++ )
    {
        if( settings[i].name == name ){
            setting = settings[i];
            break;
        }
    }
    return setting;
}

const update = (response) => {
    let name = response.name
    let error = response.error
    let value = response.value
    form[name] = value;
    if( error ) form.errors[name] = error;
    else delete form.errors[name];
    if( name == 'password_confirmation' || name == 'password')
        passwordConfirmation()
}

const updateAddress = (response) => {
    let data = response.value
    form.lat = data.lat
    form.lng = data.lng
    form.country = data.country
    form.search_str = data.search_str
    form.postal_code = data.postal_code
    form.physical_address = data.location
    form.company_address = data.location
}

const passwordConfirmation = () => {
    if( form.password !== form.password_confirmation ) form.errors['password_confirmation'] = "mismatch"
    else delete form.errors['password_confirmation']
}

</script>

<template>
    <BreezeGuestLayout wide :themeColor="settings ? getSetting('theme_color',settings).value : ''">
        <Head :title="settings ? getSetting('register_title',settings).value ? getSetting('register_title',settings).value : 'Register' : 'Register'" />
        <h1 class="text-center"> {{settings ? getSetting('register_page_title',settings).value ? getSetting('register_page_title',settings).value : 'Register' : 'Register'}} </h1>
        <h2 class="text-center mb-2 text-theme">{{settings ? getSetting('register_page_sub_title',settings).value ? getSetting('register_page_sub_title',settings).value : 'Fill in below form to sign in' : 'Fill in below form to sign in'}}</h2>
        <BreezeValidationErrors class="mb-4" />
        <form @submit.prevent="submit">

            <div class="row mt-4">
                <div class="col-6 mb-4">
                        <TextInput  :noDigits="true" :noSymbols="true" :placeholder="settings ? getSetting('register_first_name_label',settings).value ? getSetting('register_first_name_label',settings).value : 'First Name' : 'First Name'" name="first_name" id="first_name" type="text" classes="text-capitalize" :class="{'border-danger':form.errors.first_name}" :required="true" v-on:save="update" />
                </div>
                <div class="col-6 mb-4">
                        <TextInput  :noDigits="true" :noSymbols="true" :placeholder="settings ? getSetting('register_last_name_label',settings).value ? getSetting('register_last_name_label',settings).value : 'Surname' : 'Surname'" name="last_name" id="last_name" type="text" classes="text-capitalize" :class="{'border-danger':form.errors.last_name}" :required="true" v-on:save="update" />
                </div>
                <div class="col-6 mb-4">
                        <TextInput  :placeholder="settings ? getSetting('register_email_label',settings).value ? getSetting('register_email_label',settings).value : 'Email Address' : 'Email Address'" unique :uniqueurl="route('users.record.exists')" name="email" id="email" type="email" :class="{'border-danger':form.errors.email}"  required v-on:save="update" />
                </div>

                <div class="col-6 mb-4">
                        <PhoneInput noLetters :min="9" :max="15" :placeholder="settings ? getSetting('register_phone_label',settings).value ? getSetting('register_phone_label',settings).value : 'Phone Number' : 'Phone Number'" unique :uniqueurl="route('users.record.exists')" name="phone" id="phone" type="text"  required v-on:save="update" />
                </div>
                <div class="col-6 mb-4">
                        <TextInput  :placeholder="settings ? getSetting('register_company_name_label',settings).value ? getSetting('register_company_name_label',settings).value : 'Company Name' : 'Company Name'" classes="text-capitalize" name="company_name" id="company_name" type="text" :class="{'border-danger':form.errors.company_name}"  required v-on:save="update" />
                </div>

                <div class="col-6 mb-4">
                        <AddressInput  :placeholder="settings ? getSetting('register_company_address_label',settings).value ? getSetting('register_company_address_label',settings).value : 'Company Location' : 'Company Location'"  name="company_address" id="company_address" type="text" :class="{'border-danger':form.errors.company_address}"  required v-on:save="updateAddress" />
                </div>
                <div class="col-6">
                        <TextInput  :placeholder="settings ? getSetting('register_password_label',settings).value ? getSetting('register_password_label',settings).value : 'Password' : 'Password'"  name="password" id="password" type="password" :class="{'border-danger':form.errors.password}"  required v-on:save="update" />
                </div>

                <div class="col-6">
                        <TextInput  :placeholder="settings ? getSetting('register_password_confirmation_label',settings).value ? getSetting('register_password_confirmation_label',settings).value : 'Confirm Password' : 'Confirm Password'"  name="password_confirmation" id="password_confirmation" type="password" :class="{'border-danger':form.errors.password_confirmation}"  required v-on:save="update" />
                </div>
            </div>

            <div class="row">
                <div class="col mt-4">
                    <input v-model="form.terms" type="checkbox" name="terms" required > &nbsp;
                    <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">{{settings ? getSetting('register_agree_to_terms_label',settings).value ? getSetting('register_agree_to_terms_label',settings).value : 'Agree to Terms and Conditions' : 'Agree to Terms and Conditions'}}</Link>
                </div>
            </div>

            <div class="flex items-center justify-end mt-3">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{settings ? getSetting('register_login_label',settings).value ? getSetting('register_login_label',settings).value : 'Already registered?' : 'Already registered?'}}
                </Link>

                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing || Object.keys(form.errors).length }" :disabled="form.processing || Object.keys(form.errors).length">
                    {{settings ? getSetting('register_button_label',settings).value ? getSetting('register_button_label',settings).value : 'Register' : 'Register'}}
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
