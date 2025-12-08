<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  appName: { type: String, default: 'NR Tickets' },
  companyName: { type: String, default: 'NR Impuestos' },
  logos: {
    type: Object,
    default: () => ({ light: '/images/logo-light.svg', dark: '/images/logo-dark.svg' }),
  },
  canLogin: { type: Boolean, default: true },
  canRegister: { type: Boolean, default: false },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
}
</script>

<template>
  <Head :title="`${appName} · ${companyName}`" />

  <div class="min-h-screen bg-gradient-to-br from-white to-gray-50 dark:from-black dark:to-zinc-900">
    <!-- Header -->
    <header class="container mx-auto px-6 py-6 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img :src="logos.light" class="h-8 dark:hidden" alt="Logo" />
        <img :src="logos.dark" class="h-8 hidden dark:block" alt="Logo" />
        <div class="hidden sm:block">
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ companyName }}</p>
          <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ appName }}</h1>
        </div>
      </div>
      <!-- <nav v-if="canLogin" class="flex items-center gap-3">
        <Link v-if="$page.props.auth?.user" :href="route('dashboard')" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Ir al dashboard</Link>
        <template v-else>
          <Link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Iniciar sesión</Link>
          <Link v-if="canRegister" :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">Registrarse</Link>
        </template>
      </nav> -->
    </header>

    <!-- Hero + Login -->
    <section class="container mx-auto px-6 py-10 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-primary-50 text-brand-primary-700 text-xs font-medium ring-1 ring-brand-primary-100 dark:bg-brand-primary-900/30 dark:text-brand-primary-300 dark:ring-brand-primary-900">Plataforma de gestión de tickets</span>
        <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
          Control profesional con un toque <span class="text-brand-primary-600 dark:text-brand-primary-400">vibrante</span>
        </h2>
        <p class="mt-4 text-gray-700 dark:text-gray-300">
          {{ appName }} centraliza servicios, evidencias y seguimiento por sucursal y empleado. Un flujo ágil, una interfaz moderna y la seriedad que tu operación necesita.
        </p>

        <div class="mt-6 flex items-center gap-4">
          <!-- <Link :href="route('login')" class="inline-flex items-center rounded-md bg-brand-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-primary-500 focus:outline-none focus:ring-2 focus:ring-brand-primary-400">Entrar al panel</Link> -->
          <a href="#caracteristicas" class="inline-flex items-center gap-1 text-sm font-semibold text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
            Ver características
            <span class="inline-block h-4 w-4 text-brand-accent-500">→</span>
          </a>
        </div>

        <div class="mt-8 flex items-center gap-6 text-gray-500 dark:text-gray-400">
          <div class="flex -space-x-2">
            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=12" alt="Cliente" />
            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=32" alt="Cliente" />
            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=7" alt="Cliente" />
          </div>
          <p class="text-sm">Equipos ya confían en {{ companyName }}</p>
        </div>
      </div>

      <!-- Login Card -->
      <div class="rounded-2xl border border-gray-200 bg-white/70 backdrop-blur p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/60">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Acceso seguro</h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ingresa para gestionar servicios, evidencias y seguimiento en un solo lugar.</p>

        <form class="mt-6 space-y-4" @submit.prevent="submit">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correo electrónico</label>
            <input v-model="form.email" type="email" required autocomplete="email" class="mt-1 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white" placeholder="tucorreo@empresa.com" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña</label>
            <input v-model="form.password" type="password" required autocomplete="current-password" class="mt-1 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white" placeholder="••••••••" />
          </div>

          <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
              <input type="checkbox" v-model="form.remember" class="rounded border-gray-300 text-brand-primary-600 focus:ring-brand-primary-500 dark:border-zinc-700" />
              Recordarme
            </label>
            <Link :href="route('password.request')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">¿Olvidaste tu contraseña?</Link>
          </div>

          <button type="submit" :disabled="form.processing" class="w-full inline-flex items-center justify-center rounded-md bg-brand-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-primary-500 focus:outline-none focus:ring-2 focus:ring-brand-primary-400 disabled:opacity-50">
            <span v-if="!form.processing">Entrar</span>
            <span v-else>Entrando…</span>
          </button>

          <p v-if="form.errors.email || form.errors.password" class="text-sm text-red-600">
            {{ form.errors.email || form.errors.password }}
          </p>
        </form>
      </div>
    </section>

    <!-- Features -->
    <section id="caracteristicas" class="container mx-auto px-6 py-12">
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
          <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">📦</span>
            <h4 class="font-semibold text-gray-900 dark:text-white">Gestión de Servicios</h4>
          </div>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Organiza y da seguimiento a servicios por sucursal y empleado.</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
          <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">🖼️</span>
            <h4 class="font-semibold text-gray-900 dark:text-white">Evidencias con imágenes</h4>
          </div>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Carga optimizada y compresión automática para agilizar la revisión.</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
          <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">🔐</span>
            <h4 class="font-semibold text-gray-900 dark:text-white">Acceso seguro</h4>
          </div>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Autenticación robusta y permisos por rol para un acceso confiable.</p>
        </div>
      </div>
    </section>

    <!-- Metrics Strip -->
    <section class="container mx-auto px-6 py-6">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="rounded-xl bg-white p-4 text-center ring-1 ring-gray-200 dark:bg-zinc-900 dark:ring-zinc-800">
          <p class="text-2xl font-bold text-gray-900 dark:text-white">+120</p>
          <p class="text-xs text-gray-600 dark:text-gray-300">Tickets/mes</p>
        </div>
        <div class="rounded-xl bg-white p-4 text-center ring-1 ring-gray-200 dark:bg-zinc-900 dark:ring-zinc-800">
          <p class="text-2xl font-bold text-gray-900 dark:text-white">2.4h</p>
          <p class="text-xs text-gray-600 dark:text-gray-300">Tiempo de respuesta</p>
        </div>
        <div class="rounded-xl bg-white p-4 text-center ring-1 ring-gray-200 dark:bg-zinc-900 dark:ring-zinc-800">
          <p class="text-2xl font-bold text-gray-900 dark:text-white">98%</p>
          <p class="text-xs text-gray-600 dark:text-gray-300">SLA cumplido</p>
        </div>
        <div class="rounded-xl bg-white p-4 text-center ring-1 ring-gray-200 dark:bg-zinc-900 dark:ring-zinc-800">
          <p class="text-2xl font-bold text-gray-900 dark:text-white">24</p>
          <p class="text-xs text-gray-600 dark:text-gray-300">Sucursales activas</p>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="container mx-auto px-6 py-12">
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lo que dicen nuestros clientes</h3>
          <div class="hidden sm:flex -space-x-3">
            <img class="h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=14" alt="Cliente" />
            <img class="h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=18" alt="Cliente" />
            <img class="h-8 w-8 rounded-full ring-2 ring-white dark:ring-zinc-800" src="https://i.pravatar.cc/64?img=22" alt="Cliente" />
          </div>
        </div>

        <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <figure class="rounded-xl p-4 ring-1 ring-gray-200 bg-white dark:bg-zinc-900 dark:ring-zinc-800">
            <blockquote class="text-sm text-gray-700 dark:text-gray-300">“Reducimos el tiempo de seguimiento en un 40%. La carga de evidencias es súper rápida y el equipo lo adoptó en días.”</blockquote>
            <figcaption class="mt-3 flex items-center gap-3">
              <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/64?img=3" alt="" />
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Ana Gómez</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Operaciones, Retail MX</p>
              </div>
            </figcaption>
          </figure>

          <figure class="rounded-xl p-4 ring-1 ring-gray-200 bg-white dark:bg-zinc-900 dark:ring-zinc-800">
            <blockquote class="text-sm text-gray-700 dark:text-gray-300">“La visibilidad por sucursal nos permitió detectar cuellos de botella y mejorar el SLA.”</blockquote>
            <figcaption class="mt-3 flex items-center gap-3">
              <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/64?img=8" alt="" />
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">Luis Pérez</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">IT Manager, Servicios</p>
              </div>
            </figcaption>
          </figure>

          <figure class="rounded-xl p-4 ring-1 ring-gray-200 bg-white dark:bg-zinc-900 dark:ring-zinc-800">
            <blockquote class="text-sm text-gray-700 dark:text-gray-300">“Interfaz moderna, sin curva de aprendizaje. El equipo de soporte es muy atento.”</blockquote>
            <figcaption class="mt-3 flex items-center gap-3">
              <img class="h-8 w-8 rounded-full" src="https://i.pravatar.cc/64?img=28" alt="" />
              <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">María Ruiz</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">CX Lead, Finanzas</p>
              </div>
            </figcaption>
          </figure>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer class="container mx-auto px-6 py-10 text-sm text-gray-500 dark:text-gray-400">
      <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <p>© {{ new Date().getFullYear() }} {{ companyName }} · {{ appName }}</p>
        <div class="flex items-center gap-4">
          <a href="#" class="hover:text-gray-700 dark:hover:text-white">Términos</a>
          <a href="#" class="hover:text-gray-700 dark:hover:text-white">Privacidad</a>
        </div>
      </div>
    </footer>
  </div>
  
</template>
