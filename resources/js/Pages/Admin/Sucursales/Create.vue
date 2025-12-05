<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    codigo: '',
});

const submit = () => {
    form.post(route('admin.sucursales.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Crear Sucursal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link
                    :href="route('admin.sucursales.index')"
                    class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Crear Sucursal
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6">
                        <!-- Name -->
                        <div class="mb-6">
                            <InputLabel for="nombre" value="Nombre de la Sucursal" />
                            <TextInput
                                id="nombre"
                                v-model="form.nombre"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                placeholder="Ej: Ciudad de México"
                            />
                            <InputError :message="form.errors.nombre" class="mt-2" />
                        </div>

                        <!-- Code -->
                        <div class="mb-6">
                            <InputLabel for="codigo" value="Código (opcional)" />
                            <TextInput
                                id="codigo"
                                v-model="form.codigo"
                                type="text"
                                class="mt-1 block w-full font-mono uppercase"
                                placeholder="Ej: CDMX"
                                maxlength="50"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Código corto para identificar la sucursal.
                            </p>
                            <InputError :message="form.errors.codigo" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <Link
                                :href="route('admin.sucursales.index')"
                                class="mr-4 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
                            >
                                Cancelar
                            </Link>
                            <PrimaryButton :disabled="form.processing">
                                <span v-if="form.processing">Guardando...</span>
                                <span v-else>Crear Sucursal</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
