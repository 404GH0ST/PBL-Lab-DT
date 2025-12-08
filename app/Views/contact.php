<section id="contactUs" class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Contact</p>
                <h2 class="fw-bold display-5 mb-4">Let's build something meaningful together</h2>
                <p class="text-muted mb-5" style="font-size: 1.1rem;">
                    We welcome collaborations with fellow researchers, students, and industry partners. Reach out to
                    learn how we can co-create impactful data solutions.
                </p>

                <div class="d-flex align-items-center gap-4 p-4 rounded-4"
                    style="background: rgba(122, 188, 82, 0.05);">
                    <div class="feature-icon-box mb-0 bg-white shadow-sm">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark">Email Us</span>
                        <span class="text-muted">lab.datatech@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-modern p-5">
                    <?php if (!empty($_SESSION['flash_success'])): ?>
                        <div class="alert alert-success mt-3">
                            <?= $_SESSION['flash_success'] ?>
                        </div>
                        <?php unset($_SESSION['flash_success']); ?>
                    <?php endif; ?>
                    <form action="/contact/send" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control p-3 bg-light border-0" name="name" id="name"
                                    placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control p-3 bg-light border-0" name="email" id="email"
                                    placeholder="john@example.com">
                            </div>
                            <div class="col-12">
                                <label for="organization" class="form-label fw-bold">Organization <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control p-3 bg-light border-0" name="organization"
                                    id="organization" placeholder="University / Company">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-bold">How Can we Help?</label>
                                <textarea class="form-control p-3 bg-light border-0" name="message" id="message"
                                    rows="5" placeholder="Tell us about your project..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-modern btn-primary-custom w-100 py-3">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>