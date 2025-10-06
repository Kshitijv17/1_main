@extends('user.layout')

@section('title', 'Terms & Conditions - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
            </ol>
        </div>
    </nav>

    <!-- Terms & Conditions Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Terms & Conditions</h1>
                    <p class="lead text-muted">Please read these terms carefully before using our services</p>
                    <p class="small text-muted">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Acceptance of Terms</h2>
                        <p class="text-muted">
                            By accessing and using HerbnHouse website and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Use License</h2>
                        <p class="text-muted mb-3">
                            Permission is granted to temporarily download one copy of the materials on HerbnHouse's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                        </p>
                        <ul class="text-muted">
                            <li>Modify or copy the materials</li>
                            <li>Use the materials for any commercial purpose or for any public display</li>
                            <li>Attempt to reverse engineer any software contained on the website</li>
                            <li>Remove any copyright or other proprietary notations from the materials</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Product Information</h2>
                        <p class="text-muted">
                            We strive to provide accurate product information, including descriptions, prices, and availability. However, we do not warrant that product descriptions or other content is accurate, complete, reliable, current, or error-free. Colors and images are for illustration purposes only and may vary from actual products.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Pricing and Payment</h2>
                        <ul class="text-muted">
                            <li>All prices are listed in Indian Rupees (INR) unless otherwise specified</li>
                            <li>Prices are subject to change without notice</li>
                            <li>We reserve the right to refuse or cancel orders for any reason</li>
                            <li>Payment must be received before products are shipped</li>
                            <li>We accept various payment methods as displayed during checkout</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Order Acceptance</h2>
                        <p class="text-muted">
                            Your order is an offer to buy the product(s) in your cart. All orders are subject to acceptance by us, and we will confirm such acceptance to you by sending you an email that confirms we are processing your order. We may choose not to accept orders at our sole discretion.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">User Accounts</h2>
                        <p class="text-muted mb-3">
                            When you create an account with us, you must provide information that is accurate, complete, and current at all times. You are responsible for:
                        </p>
                        <ul class="text-muted">
                            <li>Safeguarding your password and account information</li>
                            <li>All activities that occur under your account</li>
                            <li>Notifying us immediately of any unauthorized use</li>
                            <li>Ensuring your contact information is up to date</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Prohibited Uses</h2>
                        <p class="text-muted mb-3">You may not use our service:</p>
                        <ul class="text-muted">
                            <li>For any unlawful purpose or to solicit others to perform unlawful acts</li>
                            <li>To violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances</li>
                            <li>To infringe upon or violate our intellectual property rights or the intellectual property rights of others</li>
                            <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
                            <li>To submit false or misleading information</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Disclaimer</h2>
                        <p class="text-muted">
                            The information on this website is provided on an "as is" basis. To the fullest extent permitted by law, this Company excludes all representations, warranties, conditions and terms whether express or implied, statutory or otherwise.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Limitations</h2>
                        <p class="text-muted">
                            In no event shall HerbnHouse or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on HerbnHouse's website.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Governing Law</h2>
                        <p class="text-muted">
                            These terms and conditions are governed by and construed in accordance with the laws of India and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.
                        </p>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-dark mb-3">Contact Information</h2>
                        <p class="text-muted mb-3">
                            If you have any questions about these Terms & Conditions, please contact us:
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
</style>
@endsection
