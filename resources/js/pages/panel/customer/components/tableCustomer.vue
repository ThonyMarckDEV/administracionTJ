<template>
    <div class="container mx-auto px-4 py-2">
        <LoadingTable v-if="loading" :headers="8" :row-count="10" />
        <div v-else class="space-y-4">
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm dark:border-gray-700 dark:shadow-none">
                <Table class="w-full">
                    <TableHeader class="bg-gray-50 dark:bg-gray-800/50">
                        <TableRow class="hover:bg-transparent">
<TableHead
    @click="sortBy('id')"
    class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 cursor-pointer select-none"
>
    <div class="inline-flex items-center space-x-1">
        <span>ID</span>
        <span v-if="sortField === 'id'">
            <span v-if="sortDirection === 'asc'">▲</span>
            <span v-else>▼</span>
        </span>
    </div>
</TableHead>

<TableHead
    @click="sortBy('name')"
    class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 cursor-pointer select-none"
>
    <div class="inline-flex items-center space-x-1">
        <span>NOMBRE</span>
        <span v-if="sortField === 'name'">
            <span v-if="sortDirection === 'asc'">▲</span>
            <span v-else>▼</span>
        </span>
    </div>
</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">CÓDIGO</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">EMAIL</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">DNI</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">RUC</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">ESTADO</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">TIPO DE CLIENTE</TableHead>
                            <TableHead class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">FECHA</TableHead>
                            <TableHead class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">ACCIONES</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <TableRow
                            v-for="customer in customerList"
                            :key="customer.id"
                            class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/30"
                        >
                            <TableCell class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ customer.id }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ customer.name }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ customer.codigo }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ customer.email }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ customer.dni || '-' }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ customer.ruc || '-' }}</TableCell>
                            <TableCell class="px-4 py-3">
                                <span
                                    v-if="customer.state === true"
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-500 dark:bg-green-400"></span>
                                    Activo
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900/30 dark:text-red-200"
                                >
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-500 dark:bg-red-400"></span>
                                    Inactivo
                                </span>
                            </TableCell>
                            <TableCell class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ customer.client_type }}</TableCell>
                            <TableCell class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ customer.created_at }}</TableCell>
                            <TableCell class="flex justify-end space-x-2 px-4 py-3">
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    class="h-8 w-8 p-0 text-orange-600 hover:bg-orange-50 hover:text-orange-700 dark:text-orange-400 dark:hover:bg-orange-900/30 dark:hover:text-orange-300"
                                    @click="openModal(customer.id)"
                                    title="Editar cliente"
                                >
                                    <UserPen class="h-4 w-4" />
                                    <span class="sr-only">Editar cliente</span>
                                </Button>
                                <Button
                                    variant="ghost"
                                    size="sm"
                                    class="h-8 w-8 p-0 text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/30 dark:hover:text-red-300"
                                    @click="openModalDelete(customer.id)"
                                    title="Eliminar cliente"
                                >
                                    <Trash class="h-4 w-4" />
                                    <span class="sr-only">Eliminar cliente</span>
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <PaginationCustomer :meta="customerPaginate" @page-change="$emit('page-change', $event)" class="mt-6" />
        </div>
    </div>
</template>

<script setup lang="ts">
import LoadingTable from '@/components/loadingTable.vue';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast';
import { Pagination } from '@/interface/paginacion';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Trash, UserPen } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { CustomerResource } from '../interface/Customer';
import PaginationCustomer from '../../../../components/pagination.vue';

const { toast } = useToast();
const emit = defineEmits<{
    (e: 'page-change', page: number): void;
    (e: 'open-modal', id_customer: number): void;
    (e: 'open-modal-delete', id_customer: number): void;
}>();

const page = usePage<SharedData>();

// Control del ordenamiento
const sortField = ref('');
const sortDirection = ref<'asc' | 'desc'>('asc');

const sortBy = (field: keyof CustomerResource) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }

    customerList.sort((a, b) => {
        const aVal = String(a[field]).toLowerCase?.() || '';
        const bVal = String(b[field]).toLowerCase?.() || '';
        
        if (aVal < bVal) return sortDirection.value === 'asc' ? -1 : 1;
        if (aVal > bVal) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });
};

const message = ref(page.props.flash?.message || '');
onMounted(() => {
    if (message.value) {
        toast({
            title: 'Notificación',
            description: message.value,
        });
    }
});

const { customerList, customerPaginate, loading } = defineProps<{
    customerList: CustomerResource[];
    customerPaginate: Pagination;
    loading: boolean;
}>();

const openModal = (id: number) => {
    emit('open-modal', id);
};

const openModalDelete = (id: number) => {
    emit('open-modal-delete', id);
};
</script>

<style scoped>
.dark .TableHeader {
    background-color: rgba(31, 41, 55, 0.5);
    border-bottom-color: rgba(55, 65, 81, 0.5);
}

.TableRow {
    transition:
        background-color 0.15s ease,
        transform 0.1s ease;
}

.TableRow:hover {
    transform: translateY(-1px);
}

.TableBody:empty::after {
    content: 'No se encontraron clientes';
    display: block;
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.dark .TableBody:empty::after {
    color: #9ca3af;
}
</style>