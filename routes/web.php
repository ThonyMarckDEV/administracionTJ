<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\Panel\InvoiceController;
use App\Http\Controllers\Reportes\ClientTypePDFController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Reportes\ServicePDFController;
use App\Http\Controllers\Reportes\AmountPDFController;
use App\Http\Controllers\Reportes\SupplierPDFController;
use App\Http\Controllers\Reportes\UserPDFController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\Inputs\AutoCompleteController;
use App\Http\Controllers\Inputs\SelectController;
use App\Http\Controllers\Panel\AmountController;
use App\Http\Controllers\Reportes\CategoryPDFController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Panel\PaymentController;
use App\Http\Controllers\PaymentPlanController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\Reportes\CustomerPDFController;
use App\Http\Controllers\Reportes\PeriodPDFController;
use App\Http\Controllers\Reportes\PaymentPlanPDFController;
use App\Http\Controllers\Reportes\PaymentPDFController;
use App\Http\Controllers\Reportes\InvoicePDFController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


# list prueba suppliers 

# route group for panel
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('panel')->name('panel.')->group(function () {
        # module users
        Route::resource('users', UserController::class);
        # list users
        Route::get('listar-users', [UserController::class, 'listarUsers'])->name('users.listar');
        # module suppliers
        Route::resource('suppliers', SupplierController::class);
        # list suppliers
        Route::get('listar-suppliers', [SupplierController::class, 'listarProveedor'])->name('suppliers.listar');
        # module Services
        Route::resource('services', ServiceController::class);
        # list Services
        Route::get('listar-services', [ServiceController::class, 'listarServices'])->name('services.listar');
        # module Client Types
        Route::resource('clientTypes', ClientTypeController::class);
        # list Client Types
        Route::get('listar-clientTypes', [ClientTypeController::class, 'listarClientTypes'])->name('clientTypes.listar');
        # module Discount
        Route::resource('discounts', DiscountController::class);
        # list Discount
        Route::get('listar-discounts', [DiscountController::class, 'listarDiscounts'])->name('discounts.listar');
        # module Categories
        Route::resource('categories', CategoryController::class);
        # list Categories
        Route::get('listar-categories', [CategoryController::class, 'listarCategories'])->name('categories.listar');
        # module Customers
        Route::resource('customers', CustomerController::class);
        # list Customers
        Route::get('listar-customers', [CustomerController::class, 'listarCustomers'])->name('customers.listar');
        # module Periods
        Route::resource('periods', PeriodController::class);
        # list Periods
        Route::get('listar-periods', [PeriodController::class, 'listarPeriods'])->name('periods.listar');
        # module Amount
        Route::resource('amounts', AmountController::class);
        # list Amount
        Route::get('listar-amounts', [AmountController::class, 'listAmount'])->name('amounts.listar');
        # module Payment Plan
        Route::resource('paymentPlans', PaymentPlanController::class);
        # list Payment Plans
        Route::get('listar-paymentPlans', [PaymentPlanController::class, 'listarPaymentPlans'])->name('paymentPlans.listar');
        # module Payment 
        Route::resource('payments', PaymentController::class);
        # list Payments
        Route::get('listar-payments', [PaymentController::class, 'listPayments'])->name('payments.listar');
        #Generate Amount PDF
        Route::get('/amounts/{amount}/pdf', [AmountController::class, 'generatePdf'])->name('panel.amounts.pdf');
        
        // Rutas existentes (no se modifican)
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/listar-invoices', [InvoiceController::class, 'listarInvoices'])->name('invoices.list');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/invoices/{invoice}/annul', [InvoiceController::class, 'annul'])->name('invoices.annul');
        Route::get('/invoices/{invoice}/pdf/{payment_id}', [InvoiceController::class, 'viewPdf'])->name('invoices.pdf');
        Route::get('/invoices/{invoice}/xml/{payment_id}', [InvoiceController::class, 'downloadXml'])->name('invoices.xml');
        Route::get('/invoices/{invoice}/cdr/{payment_id}', [InvoiceController::class, 'downloadCdr'])->name('invoices.cdr');
        // Nuevas rutas para archivos de baja
        Route::get('/invoices/{invoice}/voided/xml', [InvoiceController::class, 'downloadVoidedXml'])->name('invoices.voided.xml');
        Route::get('/invoices/{invoice}/voided/cdr', [InvoiceController::class, 'downloadVoidedCdr'])->name('invoices.voided.cdr');

        # Route group for reports
        Route::prefix('reports')->name('reports.')->group(function () {
            # Exports to Excel
            Route::get('/export-excel-users', [UserController::class, 'exportExcel'])->name('users.excel');
            Route::get('/export-excel-suppliers', [SupplierController::class, 'exportExcel'])->name('suppliers.excel');
            Route::get('/export-excel-services', [ServiceController::class, 'exportExcel'])->name('services.excel');
            Route::get('/export-excel-clientTypes', [ClientTypeController::class, 'exportExcel'])->name('clientTypes.excel');
            Route::get('/export-excel-categories', [CategoryController::class, 'exportExcel'])->name('categories.excel');
            Route::get('/export-excel-customers', [CustomerController::class, 'exportExcel'])->name('customers.excel');
            Route::get('/export-excel-periods', [PeriodController::class, 'exportExcel'])->name('periods.excel');
            Route::get('/export-excel-amounts', [AmountController::class, 'exportExcel'])->name('amounts.excel');
            Route::get('/export-excel-payment_plans', [PaymentPlanController::class, 'exportExcel'])->name('payment_plans.excel');
            Route::get('/export-excel-payments', [PaymentController::class, 'exportExcel'])->name('payments.excel');
            Route::get('/export-excel-invoices', [InvoiceController::class, 'exportExcel'])->name('invoices.excel');
            # Exports to PDF
            Route::get('/export-pdf-users', [UserPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-suppliers', [SupplierPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-services', [ServicePDFController::class, 'exportPDF']);
            Route::get('/export-pdf-clientTypes', [ClientTypePDFController::class, 'exportPDF']);
            Route::get('/export-pdf-categories', [CategoryPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-customers', [CustomerPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-periods', [PeriodPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-amounts', [AmountPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-payment_plans', [PaymentPlanPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-payments', [PaymentPDFController::class, 'exportPDF']);
            Route::get('/export-pdf-invoices', [InvoicePDFController::class, 'exportPDF']);

            #Excel imports
            Route::post('/import-excel-clientTypes', [ClientTypeController::class, 'importExcel'])->name('reports.clientTypes.import');
            Route::post('/import-excel-customers', [CustomerController::class, 'importExcel'])->name('reports.customers.import');
            Route::post('/import-excel-users', [UserController::class, 'importExcel'])->name('reports.users.import');
            Route::post('/import-excel-suppliers', [SupplierController::class, 'importExcel'])->name('reports.suppliers.import');
            Route::post('/import-excel-services', [ServiceController::class, 'importExcel'])->name('reports.services.import');
            Route::post('/import-excel-periods', [PeriodController::class, 'importExcel'])->name('reports.periods.import');
            Route::post('/import-excel-amounts', [AmountController::class, 'importExcel'])->name('reports.amounts.import');
            Route::post('/import-excel-categories', [CategoryController::class, 'importExcel'])->name('reports.categories.import');
        });

        # Ruta para dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth']);

        # Route group for inputs, selects and autocomplete
        Route::prefix('inputs')->name('inputs.')->group(function () {
            # get client_type list
            Route::get('client_type_list', [SelectController::class, 'getClientTypeList'])->name('client_type_list');
            Route::get('categories_list', [SelectController::class, 'getCategoriesList'])->name('categories_list');
            Route::get('service_list', [SelectController::class, 'getServiceList'])->name('service_list');
            Route::get('period_list', [SelectController::class, 'getPeriodList'])->name('period_list');
            Route::get('customer_list', [SelectController::class, 'getCustomerList'])->name('customer_list');
            Route::get('discount_list', [SelectController::class, 'getDiscountList'])->name('discount_list');
            // automplete
            Route::get('suppliers_list', [AutoCompleteController::class, 'getSuppliersList'])->name('suppliers_list');
            Route::get('customers_list', [AutoCompleteController::class, 'getCustomerList'])->name('customers_list');
            Route::get('services_list', [AutoCompleteController::class, 'getServiceList'])->name('services_list');
        });
    });
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
