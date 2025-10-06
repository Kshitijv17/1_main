@extends('user.layout')

@section('title', 'Refund and Cancellation Policy - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Refund and Cancellation Policy</li>
            </ol>
        </div>
    </nav>

    <!-- Refund and Cancellation Policy Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Refund and Cancellation Policy</h1>
                    <p class="lead text-muted">Flexible cancellation and hassle-free refunds</p>
                    <p class="small text-muted">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Order Cancellation</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="fw-bold text-success mb-2">Before Shipping</h5>
                                    <ul class="text-muted small mb-0">
                                        <li>Free cancellation anytime</li>
                                        <li>Instant refund processing</li>
                                        <li>No cancellation charges</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h5 class="fw-bold text-warning mb-2">After Shipping</h5>
                                    <ul class="text-muted small mb-0">
                                        <li>Contact user support</li>
                                        <li>Return process required</li>
                                        <li>Shipping charges may apply</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">How to Cancel Your Order</h2>
                        <ol class="text-muted">
                            <li><strong>Login to your account</strong> and go to "My Orders"</li>
                            <li><strong>Find your order</strong> and click "Cancel Order"</li>
                            <li><strong>Select cancellation reason</strong> from the dropdown</li>
                            <li><strong>Confirm cancellation</strong> - you'll receive an email confirmation</li>
                            <li><strong>Refund processing</strong> will begin automatically</li>
                        </ol>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Refund Policy</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Payment Method</th>
                                        <th>Refund Timeline</th>
                                        <th>Processing Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Credit/Debit Card</td>
                                        <td>5-7 business days</td>
                                        <td>None</td>
                                    </tr>
                                    <tr>
                                        <td>Net Banking</td>
                                        <td>5-7 business days</td>
                                        <td>None</td>
                                    </tr>
                                    <tr>
                                        <td>UPI/Digital Wallets</td>
                                        <td>1-3 business days</td>
                                        <td>None</td>
                                    </tr>
                                    <tr>
                                        <td>Cash on Delivery</td>
                                        <td>7-10 business days</td>
                                        <td>Bank transfer charges may apply</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Refund Scenarios</h2>
                        <div class="accordion" id="refundAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#refund1">
                                        Order Cancellation Before Shipping
                                    </button>
                                </h3>
                                <div id="refund1" class="accordion-collapse collapse show" data-bs-parent="#refundAccordion">
                                    <div class="accordion-body text-muted">
                                        <strong>100% refund</strong> of the order amount including any shipping charges paid. Refund processed within 24 hours of cancellation.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#refund2">
                                        Return Due to Defective/Wrong Item
                                    </button>
                                </h3>
                                <div id="refund2" class="accordion-collapse collapse" data-bs-parent="#refundAccordion">
                                    <div class="accordion-body text-muted">
                                        <strong>100% refund</strong> including return shipping costs. We also provide a prepaid return label for your convenience.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#refund3">
                                        Return Due to Change of Mind
                                    </button>
                                </h3>
                                <div id="refund3" class="accordion-collapse collapse" data-bs-parent="#refundAccordion">
                                    <div class="accordion-body text-muted">
                                        <strong>Product amount refund</strong> minus return shipping charges. Original shipping charges are non-refundable.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Partial Cancellations</h2>
                        <p class="text-muted">
                            For orders with multiple items, you can cancel individual items before the order is shipped. The refund will be processed for the cancelled items only, and the remaining items will be shipped as scheduled.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Non-Refundable Situations</h2>
                        <ul class="text-muted">
                            <li>Items used or consumed beyond the return period</li>
                            <li>Custom or personalized products (unless defective)</li>
                            <li>Items damaged due to misuse or negligence</li>
                            <li>Products returned without original packaging</li>
                            <li>Hygiene-sensitive items that have been opened</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Refund Status Tracking</h2>
                        <p class="text-muted mb-3">You can track your refund status through:</p>
                        <ul class="text-muted">
                            <li>Your account dashboard under "My Orders"</li>
                            <li>Email notifications at each stage</li>
                            <li>SMS updates for refund processing</li>
                            <li>User support for detailed status</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Delayed Refunds</h2>
                        <p class="text-muted">
                            If you haven't received your refund within the specified timeline, please check with your bank first. If the issue persists, contact our user support with your order number and payment details.
                        </p>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-dark mb-3">Contact for Refund Queries</h2>
                        <p class="text-muted mb-3">
                            For any refund or cancellation queries:
                        </p>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-2">
                                <i class="fas fa-phone text-success me-2"></i>
                                <a href="tel:+916376191966" class="text-decoration-none text-dark">+91 6376191966</a>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-envelope text-success me-2"></i>
                                <a href="mailto:theherbandhouse@gmail.com" class="text-decoration-none text-dark">theherbandhouse@gmail.com</a>
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb-item + .breadcrumb-item::before {
    color: #6c757d;
}

.breadcrumb-item a:hover {
    color: #8B4513 !important;
}

.text-success {
    color: #8B4513 !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

section {
    border-bottom: 1px solid #eee;
    padding-bottom: 1.5rem;
}

section:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #8B4513;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
}
</style>
@endsection
