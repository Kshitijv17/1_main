@extends('user.layout')

@section('title', 'Shipping Policy - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
            </ol>
        </div>
    </nav>

    <!-- Shipping Policy Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Shipping Policy</h1>
                    <p class="lead text-muted">Fast, reliable delivery to your doorstep</p>
                    <p class="small text-muted">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Shipping Areas</h2>
                        <p class="text-muted mb-3">We currently ship to:</p>
                        <ul class="text-muted">
                            <li>All major cities across India</li>
                            <li>Rural areas (delivery time may vary)</li>
                            <li>Pin codes serviceable by our logistics partners</li>
                        </ul>
                        <p class="text-muted">
                            Please enter your pin code during checkout to confirm delivery availability in your area.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Shipping Charges</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order Value</th>
                                        <th>Shipping Charge</th>
                                        <th>Delivery Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Above ₹500</td>
                                        <td class="text-success fw-bold">FREE</td>
                                        <td>3-5 business days</td>
                                    </tr>
                                    <tr>
                                        <td>₹200 - ₹499</td>
                                        <td>₹50</td>
                                        <td>3-5 business days</td>
                                    </tr>
                                    <tr>
                                        <td>Below ₹200</td>
                                        <td>₹80</td>
                                        <td>5-7 business days</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Processing Time</h2>
                        <ul class="text-muted">
                            <li><strong>In-stock items:</strong> 1-2 business days</li>
                            <li><strong>Pre-order items:</strong> As mentioned on product page</li>
                            <li><strong>Custom/Made-to-order:</strong> 5-7 business days</li>
                            <li><strong>Bulk orders:</strong> 3-5 business days</li>
                        </ul>
                        <p class="text-muted">
                            Processing time is calculated from the date of order confirmation and payment verification.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Delivery Partners</h2>
                        <p class="text-muted mb-3">We work with trusted logistics partners:</p>
                        <ul class="text-muted">
                            <li>Blue Dart</li>
                            <li>DTDC</li>
                            <li>India Post</li>
                            <li>Local courier services for faster delivery</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Order Tracking</h2>
                        <p class="text-muted">
                            Once your order is shipped, you will receive a tracking number via email and SMS. You can track your order status in real-time through our website or the courier partner's website.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Special Handling</h2>
                        <ul class="text-muted">
                            <li><strong>Fragile items:</strong> Extra protective packaging</li>
                            <li><strong>Liquid products:</strong> Leak-proof packaging</li>
                            <li><strong>Perishable items:</strong> Temperature-controlled shipping when required</li>
                            <li><strong>High-value items:</strong> Signature required on delivery</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Delivery Issues</h2>
                        <p class="text-muted mb-3">If you experience any delivery issues:</p>
                        <ul class="text-muted">
                            <li>Contact us within 24 hours of expected delivery date</li>
                            <li>Provide your order number and tracking details</li>
                            <li>We will investigate and resolve the issue promptly</li>
                            <li>Compensation may be provided for verified delivery failures</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-dark mb-3">Contact for Shipping Queries</h2>
                        <p class="text-muted mb-3">
                            For any shipping-related questions, please contact us:
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

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection
