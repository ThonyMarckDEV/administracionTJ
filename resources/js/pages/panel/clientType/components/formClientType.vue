<template>
    <Head title="Nuevo Tipo de cliente"></Head>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="mt-4 flex flex-col gap-4">
                <CardHeader>
                    <CardTitle>NUEVO TIPO DE CLIENTE</CardTitle>
                    <CardDescription>Complete los campos para crear un nuevo tipo de cliente</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit="onSubmit" class="flex flex-col gap-6">

                        <!-- Campo para ingresar el nombre del tipo de cliente -->
                        <FormField v-slot="{ componentField }" name="name">
                            <FormItem>
                                <FormLabel>Tipo de Cliente</FormLabel>
                                <FormControl>
                                    <Input type="text" placeholder="Cliente eficiente" v-bind="componentField"/>
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        </FormField>

                        <!-- Campo para elegir el estado del tipo de cliente -->
              <FormField v-slot="{ componentField }" name="state">
                    <FormItem>
                        <FormLabel>Estado</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField" disabled>
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona el estado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Estado</SelectLabel>
                                        <SelectItem value="activo">Activo</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                        <!-- BOTONES PARA ENVIAR O BORRAR -->
                        <div class="container flex justify-end gap-4">
                            <Button type="submit" variant="default"> Enviar </Button>
                            <Button type="reset" variant="outline"> Borrar </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">

//Importaciones para hacer el formulario de tipos de cliente, ok mucho texto
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectGroup, SelectItem, SelectLabel } from '@/components/ui/select';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

//composable
import { useClientType } from '@/composables/useClientType';
const { createClientType } = useClientType();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tipos de cliente',
        href: '/panel/clientTypes',
    },
    
    {
        title: 'Crear tipo de cliente',
        href: '/panel/clientTypes/create',
    },
];

//Form validation
const formShema = toTypedSchema(
    z.object({
        name: z
            .string({message: 'Campo obligatorio'})
            .min(1, {message: 'El nombre debe tener al menos 1 caracter'})
            .max(50, {message: 'El nombre debe debe tener menos de 50 caracteres '}),
        state: z.enum(['activo', 'inactivo'], { message: 'Estado inválido' }),
    }),
);

//form submit

const { handleSubmit } = useForm({
    validationSchema: formShema,
        initialValues: {         
        state: 'activo',     
    },
});


const onSubmit = handleSubmit((values) => {
    const clientTypeData = {
        name: values.name,
        state: values.state === 'activo',
    };

    createClientType(clientTypeData);
});
</script>
<style scoped></style>