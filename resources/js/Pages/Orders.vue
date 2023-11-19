<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, router, useForm} from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {computed, onMounted, reactive, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import RadioButton from "@/Components/RadioButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {Order, OrderProduct} from "@/types/models";
import {millisecondsToStr} from "../../helpers";
const props = defineProps<{
        orders: Order[],
    }>();
const currentTime = ref((new Date).getTime())
onMounted(()=>{
    setInterval(()=>{
        currentTime.value = (new Date).getTime()
    },1000)
})
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Orders</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul role="list" class="flex flex-col gap-4 pt-6">
                    <li v-for="order in orders" :key="order.id" class="flex justify-between rounded-md bg-white p-1">
                        <p class="text-xl text-gray-900">{{ order.user.name }}</p>
                        <ul class="flex flex-col gap-1">
                            <li v-for="orderProduct in order.products" class="text-xl text-gray-900">{{ orderProduct.product.title }}<span class="text-red-600" v-if="orderProduct.purchase_type && (new Date(order.payment_time)).getTime() + (orderProduct.purchase_type.validity_period * 1000)  - currentTime > 0"> - expires in {{Math.floor(((new Date(order.payment_time)).getTime() + (orderProduct.purchase_type.validity_period * 1000)  - currentTime) / 1000) }} s</span><span v-else-if="orderProduct.purchase_type" class="text-red-600"> expired</span></li>
                        </ul>
                        <p class="text-xl text-gray-900">sum: {{ order.products.reduce((acc,cur)=>acc+cur.price,0) }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
