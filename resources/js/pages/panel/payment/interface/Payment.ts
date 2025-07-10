import { Pagination } from '@/interface/paginacion';

// interface for resource payment in backend
export interface PaymentResource {
    id: number;
    customer: string;
    service: string;
    discount: number;
    amount: number;
    payment_date: string;
    payment_method: string;
    reference: string;
    status: string;
}

export interface PaymentTable {
    payments: PaymentResource[];
    pagination: Pagination;
}

export interface showPayment {
    status: boolean;
    message: string;
    payment: PaymentResource;
}

export interface updatePayment {
    customer_id: number | null;
    payment_plan_id: number | null;
    service_id: number | null;
    discount_id: number | null;
    amount: number;
    payment_date: string;
    payment_method: string;
    reference: string;
    status: string;
}

export interface updatePaymentResponse {
    status: boolean;
    message: string;
    payment: PaymentResource;
}

export interface deletePaymentResponse {
    status: boolean;
    message: string;
}
