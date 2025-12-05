<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    sucursales: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    numero_empleado: '',
    sucursal_id: '',
    role: 'tecnico',
});

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Crear Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link
                    :href="route('admin.users.index')"
                    class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Crear Usuario
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6">
                        <!-- Name -->
                        <div class="mb-6">
                            <InputLabel for="name" value="Nombre" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <InputLabel for="email" value="Correo Electrónico" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <InputLabel for="password" value="Contraseña" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-6">
                            <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>

                        <!-- Employee Number -->
                        <div class="mb-6">
                            <InputLabel for="numero_empleado" value="Número de Empleado (opcional)" />
                            <TextInput
                                id="numero_empleado"
                                v-model="form.numero_empleado"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.numero_empleado" class="mt-2" />
                        </div>

                        <!-- Sucursal -->
                        <div class="mb-6">
                            <InputLabel for="sucursal_id" value="Sucursal (opcional)" />
                            <select
                                id="sucursal_id"
                                v-model="form.sucursal_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >
                                <option value="">Sin asignar</option>
                                <option v-for="sucursal in sucursales.data" :key="sucursal.id" :value="sucursal.id">
                                    {{ sucursal.nombre }}
                                </option>
                            </select>
                            <InputError :message="form.errors.sucursal_id" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <InputLabel for="role" value="Rol" />
                            <select
                                id="role"
                                v-model="form.role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required
                            >
                                <option v-for="role in roles" :key="role" :value="role">
                                    {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                                </option>
                            </select>
                            <InputError :message="form.errors.role" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <Link
                                :href="route('admin.users.index')"
                                class="mr-4 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
                            >
                                Cancelar
                            </Link>
                            <PrimaryButton :disabled="form.processing">
                                <span v-if="form.processing">Guardando...</span>
                                <span v-else>Crear Usuario</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
