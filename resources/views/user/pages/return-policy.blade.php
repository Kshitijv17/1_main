@extends('user.layout')

@section('title', 'Return Policy - HerbnHouse')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Return Policy</li>
            </ol>
        </div>
    </nav>

    <!-- Return Policy Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Page Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-3">Return Policy</h1>
                    <p class="lead text-muted">Easy returns for your peace of mind</p>
                    <p class="small text-muted">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <!-- Content -->
                <div class="bg-white border rounded-3 p-4 shadow-sm">
                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Return Window</h2>
                        <p class="text-muted">
                            We offer a <strong>7-day return policy</strong> from the date of delivery. Items must be returned in their original condition with all packaging, tags, and accessories intact.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Eligible Items for Return</h2>
                        <ul class="text-muted">
                            <li>Unopened herbal powders and supplements</li>
                            <li>Unused essential oils with unbroken seals</li>
                            <li>Home décor items in original packaging</li>
                            <li>Defective or damaged products</li>
                            <li>Items that don't match the description</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Non-Returnable Items</h2>
                        <p class="text-muted mb-3">For hygiene and safety reasons, the following items cannot be returned:</p>
                        <ul class="text-muted">
                            <li>Opened food items, teas, and consumables</li>
                            <li>Used personal care products</li>
                            <li>Custom or personalized items</li>
                            <li>Items damaged due to misuse</li>
                            <li>Products without original packaging</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Return Process</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="fw-bold mb-2">Step 1: Contact Us</h5>
                                    <p class="small text-muted mb-0">Email us with your order number and reason for return</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="fw-bold mb-2">Step 2: Get Approval</h5>
                                    <p class="small text-muted mb-0">We'll review and provide return instructions</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="fw-bold mb-2">Step 3: Pack & Ship</h5>
                                    <p class="small text-muted mb-0">Pack items securely and ship to our return address</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="fw-bold mb-2">Step 4: Processing</h5>
                                    <p class="small text-muted mb-0">We'll process your return within 3-5 business days</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Return Shipping</h2>
                        <ul class="text-muted">
                            <li><strong>Defective/Wrong items:</strong> We cover return shipping costs</li>
                            <li><strong>Change of mind:</strong> User bears return shipping costs</li>
                            <li><strong>Free pickup:</strong> Available for orders above ₹1000 in select cities</li>
                            <li><strong>Packaging:</strong> Use original packaging or similar protective materials</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Inspection Process</h2>
                        <p class="text-muted mb-3">Upon receiving your return:</p>
                        <ol class="text-muted">
                            <li>We inspect the item within 2 business days</li>
                            <li>Check for original condition and packaging</li>
                            <li>Verify the reason for return</li>
                            <li>Process refund or replacement accordingly</li>
                            <li>Send confirmation email with next steps</li>
                        </ol>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Exchanges</h2>
                        <p class="text-muted">
                            We offer exchanges for defective items or size/variant changes (where applicable). Exchange requests must be made within 7 days of delivery. The replacement item will be shipped once we receive and approve the returned item.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 fw-bold text-dark mb-3">Damaged or Defective Items</h2>
                        <p class="text-muted mb-3">If you receive a damaged or defective item:</p>
                        <ul class="text-muted">
                            <li>Contact us within 24 hours of delivery</li>
                            <li>Provide photos of the damaged item and packaging</li>
                            <li>We'll arrange immediate replacement or full refund</li>
                            <li>No need to return the damaged item in most cases</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="h4 fw-bold text-dark mb-3">Contact for Returns</h2>
                        <p class="text-muted mb-3">
                            To initiate a return or for any questions:
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
