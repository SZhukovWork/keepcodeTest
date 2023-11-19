<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import {Head} from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {computed, reactive, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioButton from "@/Components/RadioButton.vue";
import {Product} from "@/types/models";

const props = defineProps<{
    products: Product[]
}>();



const closeModal = () => {
    form.product_id = null;
    form.purchase_type = null;
};
const form = useForm({
    product_id: null,
    purchase_type: null,
})
const currentProduct = computed(() => form.product_id ? props.products.find((product) => product.id == form.product_id) : null);
const currentPrice = computed(
    () =>form.purchase_type ?
            currentProduct.value.purchases.find(purchase => purchase.type.id == form.purchase_type).price :
            currentProduct.value.price

);
const submit = () => {
    form.post(route("orders.create"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            router.get(route("orders.page"))
        },
    })
};
</script>

<template>
    <Head title="Products"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link :href="route('products.create.page')"
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    add product
                </Link>
                <ul role="list" class="flex flex-col gap-4 pt-6">
                    <li v-for="product in products" :key="product.id"
                        class="flex justify-between rounded-md bg-white p-1">
                        <p class="text-xl text-gray-900">{{ product.title }}</p>
                        <p class="text-xl text-gray-900 self-end">{{ product.price }} руб.</p>
                        <SecondaryButton @click="()=>form.product_id = product.id">
                            buy
                        </SecondaryButton>
                    </li>
                </ul>
            </div>
        </div>
        <Modal :show="form.product_id" @close="closeModal">
            <form class="p-6" @submit.prevent="submit">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Buy <span class="text-indigo-400">{{ currentProduct.title }}</span>
                </h2>

                <div class="mt-6 flex items-center">

                    <RadioButton name="productPurchase" title="Навсегда" :value="null" :checked="true"
                                 v-model:active="form.purchase_type"/>
                    <RadioButton name="productPurchase" v-for="productPurchase in currentProduct.purchases"
                                 :title="productPurchase.type.title+' - '+productPurchase.price+' .руб'"
                                 :value="productPurchase.type.id" v-model:active="form.purchase_type"/>

                </div>

                <div class="mt-6 flex justify-end items-center gap-4">
                    <div class="text-gray-400">
                        {{ currentPrice }} руб.
                    </div>
                    <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        @click="buyProductAction"
                    >
                        Buy
                    </PrimaryButton>
                </div>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>
