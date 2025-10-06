@extends('user.layout')

@section('title', 'Privacy Policy - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
            </ol>
        </div>
    </nav>

    <!-- Privacy Policy Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Privacy Policy</h1>
                    <p class="lead text-muted">Your privacy is important to us</p>
                    <p class="small text-muted">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Information We Collect</h2>
                        <p class="text-muted mb-3">
                            At HerbnHouse, we collect information you provide directly to us, such as when you create an account, make a purchase, or contact us for support.
                        </p>
                        <ul class="text-muted">
                            <li>Personal information (name, email address, phone number)</li>
                            <li>Billing and shipping addresses</li>
                            <li>Payment information (processed securely through our payment partners)</li>
                            <li>Order history and preferences</li>
                            <li>Communication preferences</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">How We Use Your Information</h2>
                        <p class="text-muted mb-3">We use the information we collect to:</p>
                        <ul class="text-muted">
                            <li>Process and fulfill your orders</li>
                            <li>Communicate with you about your orders and account</li>
                            <li>Provide user support</li>
                            <li>Send you promotional emails (with your consent)</li>
                            <li>Improve our products and services</li>
                            <li>Comply with legal obligations</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Information Sharing</h2>
                        <p class="text-muted mb-3">
                            We do not sell, trade, or otherwise transfer your personal information to third parties except as described in this policy:
                        </p>
                        <ul class="text-muted">
                            <li>Service providers who assist us in operating our website and conducting business</li>
                            <li>Payment processors for secure transaction processing</li>
                            <li>Shipping companies to deliver your orders</li>
                            <li>Legal authorities when required by law</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Data Security</h2>
                        <p class="text-muted">
                            We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Cookies and Tracking</h2>
                        <p class="text-muted">
                            We use cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and understand where our visitors are coming from. You can control cookies through your browser settings.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Your Rights</h2>
                        <p class="text-muted mb-3">You have the right to:</p>
                        <ul class="text-muted">
                            <li>Access your personal information</li>
                            <li>Correct inaccurate information</li>
                            <li>Delete your account and personal information</li>
                            <li>Opt-out of marketing communications</li>
                            <li>Request data portability</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Children's Privacy</h2>
                        <p class="text-muted">
                            Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Changes to This Policy</h2>
                        <p class="text-muted">
                            We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.
                        </p>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-dark mb-3">Contact Us</h2>
                        <p class="text-muted mb-3">
                            If you have any questions about this Privacy Policy, please contact us:
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
