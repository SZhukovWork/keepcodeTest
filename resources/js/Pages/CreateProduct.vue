<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {PurchaseType} from "@/types/models";
const props = defineProps<{
    purchaseTypes: PurchaseType[]
}>();
const form = useForm({
    title: '',
    price: '',
    purchaseTypes:{},
});
const submit = () => {
    form.post(route('products.create'), {
        onBefore:(params)=>{
            for (const key in params.data.purchaseTypes){
                params.data.purchaseTypes[key] = parseFloat(params.data.purchaseTypes[key]);
            }
            console.log(params);
        },
        onSuccess:()=>{
            router.get(route("products.page"));
        }
    });
};
</script>

<template>
    <Head title="Products"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Product create</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <form @submit.prevent="submit" class="sm:max-w-md">
                <div>
                    <InputLabel for="title" value="Title" />

                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="mt-4">
                    <InputLabel for="price" value="Price" />

                    <TextInput
                        id="price"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.price"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.price" />
                </div>
                <div class="mt-4" v-for="purchaseType in purchaseTypes">
                    <InputLabel :for="purchaseType.id" :value="purchaseType.title" />

                    <TextInput
                        :id="purchaseType.id"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.purchaseTypes[purchaseType.id]"
                    />
                </div>

                <div class="flex items-center justify-end mt-4">


                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        create product
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
