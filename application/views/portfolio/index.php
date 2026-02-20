<header class="p-3 sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark rounded">
        <div class="container-fluid">
            <span class="navbar-brand">Jake's Portfolio</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-3 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item divider d-none d-lg-block">
                        <span>||</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item divider d-none d-lg-block">
                        <span>||</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">Projects</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>


<section class="container-fluid p-3 pt-5 mx-auto d-flex flex-column flex-md-row justify-content-center align-items-center min-vh-90" id="home">
    <div class="home-image w-100 w-md-50">
        <img src="<?= base_url('assets/images/prof.jpg') ?>" alt="Profile Picture" class="img-fluid rounded-circle w-50 mx-auto d-block m-4 shadow">

    </div>
    <div class="home-text w-100 w-md-50 mx-auto">
        <h1 class="display-1 text-center">Hello, I'm Jake!</h1>
        <p class="text-center display-6">I'm a website developer with experience in backend development, now taking the challenge of frontend development, eventually becoming a full-stack developer.</p>
    </div>
</section>

<section id="about" class="container-fluid p-3 pt-5 mx-auto d-flex justify-content-center align-items-center min-vh-90">
    <div class="container-xxl px-4 py-5">
        <h2 class="display-4 text-center mb-5">About Me</h2>
        <div class="row g-4">
            <article class="col-12 col-md-6 col-lg-4">
                <div class="about-card h-100 p-4 rounded shadow-sm">
                    <h3 class="about-category fw-semibold fs-4 text-center mb-3 pb-2">Education</h3>
                    <p class="lead text-center mb-0">I am a student of STI College Dasmarinas in the Bachelor of Science in Information Technology program. I won second place at STI's "Into Prog", a Java programming competition.</p>
                </div>
            </article>
            <article class="col-12 col-md-6 col-lg-4">
                <div class="about-card h-100 p-4 rounded shadow-sm">
                    <h3 class="about-category fw-semibold fs-4 text-center mb-3 pb-2">Background</h3>
                    <p class="lead text-center mb-0">I mostly build back-end systems and applications using PHP for website and Java and C# for desktop applications. I am currently taking the challenge of learning frontend development, and I am excited to see where this journey takes me.</p>
                </div>
            </article>
            <article class="col-12 col-md-6 col-lg-4">
                <div class="about-card h-100 p-4 rounded shadow-sm">
                    <h3 class="about-category fw-semibold fs-4 text-center mb-3 pb-2">Saying</h3>
                    <p class="lead text-center fst-italic mb-0">
                        "Life is a race, but that doesn't mean you have to do it alone."
                    </p>
                </div>
            </article>
        </div>
    </div>
</section>

<section id="skills" class="container-fluid p-3 pt-5 mx-auto d-flex justify-content-center align-items-center min-vh-90">
    <div class="container px-4 py-5">
        <h2 class="display-4 text-center mb-5">Skills and Proficiency</h2>
    <article>
        <div class="container-sm">
            <ul class="list-inline mx-auto my-3 d-flex flex-wrap justify-content-center gap-3 fs-4">
                <?php if (!empty($skills)): ?>
                    <?php foreach ($skills as $skill): ?>
                        <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
                            <div class="badge-flip-inner">
                                <div class="badge-flip-front">
                                    <img
                                        src="<?= base_url($skill['logo']) ?>"
                                        alt="<?= htmlspecialchars($skill['language']) ?>"
                                        style="max-height: 50px"
                                        class="img-fluid m-1" />
                                </div>
                                <div class="badge-flip-back">
                                    <div class="skill-progress-container d-flex flex-column align-items-center justify-content-center p-2 gap-2">
                                        <div class="skill-name fw-semibold small text-white text-center"><?= htmlspecialchars($skill['language']) ?></div>
                                        <div class="progress-bar-wrapper w-90">
                                            <div class="progress-bar" data-percent="<?= (int)$skill['prof'] ?>"></div>
                                        </div>
                                        <div class="skill-percent fw-bold text-white text-center"><?= (int)$skill['prof'] ?>%</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-inline-item">
                        <p class="text-center text-muted">No skills added yet. Add skills in the customize page!</p>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </article>
    </div>
</section>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.list-inline-item');

        const observerOptions = {
            threshold: 0.5,
            rootMargin: '100px 0px 100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    entry.target.classList.remove('out-of-view');
                } else {
                    entry.target.classList.remove('in-view');
                    entry.target.classList.add('out-of-view');
                }
            });
        }, observerOptions);

        items.forEach(item => observer.observe(item));

        // Animate progress bars when card flips to show back
        const badgeFlips = document.querySelectorAll('.badge-flip');
        badgeFlips.forEach(badge => {
            const progressBar = badge.querySelector('.progress-bar');
            if (progressBar) {
                const percent = progressBar.getAttribute('data-percent');
                
                badge.addEventListener('mouseenter', function() {
                    // Reset and animate progress bar when hovering
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = percent + '%';
                    }, 50);
                });
                
                badge.addEventListener('mouseleave', function() {
                    progressBar.style.width = '0%';
                });
            }
        });
    });
</script>


