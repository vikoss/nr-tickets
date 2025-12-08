<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    sucursales: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Gestión de Sucursales" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Gestión de Sucursales
                </h2>
                <Link :href="route('admin.sucursales.create')">
                    <PrimaryButton>Nueva Sucursal</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Código
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Fecha de Creación
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr v-for="sucursal in sucursales.data" :key="sucursal.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ sucursal.nombre }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        <span v-if="sucursal.codigo" class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 font-mono text-xs dark:bg-gray-700">
                                            {{ sucursal.codigo }}
                                        </span>
                                        <span v-else class="text-gray-400">-</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ new Date(sucursal.created_at).toLocaleDateString('es-MX') }}
                                    </td>
                                </tr>
                                <tr v-if="sucursales.data.length === 0">
                                    <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay sucursales registradas.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="sucursales.meta && sucursales.meta.last_page > 1" class="border-t border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-800 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                Mostrando {{ sucursales.meta.from }} a {{ sucursales.meta.to }} de {{ sucursales.meta.total }} resultados
                            </div>
                            <div class="flex space-x-2">
                                <Link
                                    v-for="link in sucursales.meta.links"
                                    :key="link.label"
                                    :href="link.url"
                                    v-html="link.label"
                                    class="rounded-md px-3 py-2 text-sm"
                                    :class="{
                                        'bg-brand-primary-500 text-white': link.active,
                                        'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300': !link.active && link.url,
                                        'cursor-not-allowed bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500': !link.url,
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
