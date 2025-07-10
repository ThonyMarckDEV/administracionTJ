import { Pagination } from '@/interface/paginacion';

export interface AmountResource {
    id: number;
    category: string;
    supplier: string;
    ruc: string;
    description: string;
    amount: number;
    date_init: string;
}
export interface AmountResponseShow {
    category_id: number;
    category_name: string;
    supplier_id: number;
    supplier_name: string;
    description: string;
    amount: number;
    date_init: string;
    serie_assigned: string;
    correlative_assigned: string;
}
export type AmountResponse = {
    amounts: AmountResource[];
    pagination: Pagination;
};

export type AmountRequestCreate = {
    description: string;
    amount: number;
    category_id: number;
    supplier_id: number;
    date_init: string;
};

export type AmountShow = {
    status: boolean;
    message: string;
    amount: AmountResponseShow;
};

export type AmountResponseDelete = {
    message: string;
    status: boolean;
};
export type AmountResponseUpdate = {
    message: string;
    status: boolean;
    amount: AmountResponseShow;
};
export interface AmountUpdatePayload {
    category_id: number;
    supplier_id: number;
    description: string;
    amount: number;
    date_init: string;
}
