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


<section class="container-fluid p-3 pt-5 mx-auto d-flex justify-content-center align-items-center" id="home">
    <div class="home-image">
        <img src="<?= base_url('assets/images/prof.jpg') ?>" alt="Profile Picture" class="img-fluid rounded-circle w-50 mx-auto d-block m-4 shadow">

    </div>
    <div class="home-text">
        <h1 class="display-1 text-center">Hello, I'm Jake!</h1>
        <p class="text-center display-6">I'm a website developer with experience in backend development, now taking the challenge of frontend development, eventually becoming a full-stack developer.</p>
    </div>
</section>

<section id="about" class="container-fluid p-3 py-5 mx-auto">
    <h2 class="display-4 text-center mb-4">About Me</h2>
    <article class="mx-5">
        <p class="lead text-center">I am a student of STI College Dasmarinas in the Bachelor of Science in Information Technology program. I mostly build back-end systems and applications using PHP for website and Java and C# for desktop applications. My past time is playing games like Valorant and watching animes and J-drama. I won second place at STI's "Into Prog", a Java programming competition.</p>
    </article>
    <article class="mx-5">
        <p class="lead text-center">I am currently taking the challenge of learning frontend development, and I am excited to see where this journey takes me. I am passionate about creating user-friendly and visually appealing websites, and I am eager to apply my skills and knowledge to real-world projects.</p>
    </article>
</section>

<section id="skills" class="container-fluid py-5">
    <article>
        <h2 class="display-5 text-center">My Skills</h2>
        <div class="container-sm mx-auto my-auto">
            <ul
                class="list-inline mx-auto my-3 d-flex flex-wrap justify-content-center"
                style="font-size: 1.4em">
                <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
                    <div class="badge-flip-inner">
                        <div class="badge-flip-front">
                            <img
                                src="<?= base_url('/assets/logo/LOGO_php.svg') ?>"
                                alt=""
                                style="max-height: 50px"
                                class="img-fluid m-1" />
                        </div>
                        <div class="badge-flip-back">

                            <span class="skill-percent">PHP || 85%</span>
                        </div>
                    </div>

                </li>

                <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
                    <div class="badge-flip-inner">
                        <div class="badge-flip-front">
                            <img
                                src="<?= base_url('/assets/logo/LOGO_html.svg') ?>"
                                alt=""
                                style="max-height: 50px"
                                class="img-fluid m-1" />
                        </div>
                        <div class="badge-flip-back">

                            <span class="skill-percent">HTML || 85%</span>
                        </div>
                    </div>
                </li>

                <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
                    <div class="badge-flip-inner">
                        <div class="badge-flip-front">
                            <img
                                src="<?= base_url('/assets/logo/LOGO_css.svg') ?>"
                                alt=""
                                style="max-height: 50px"
                                class="img-fluid m-1" />
                        </div>
                        <div class="badge-flip-back">

                            <span class="skill-percent">CSS || 85%</span>
                        </div>
                    </div>
                </li>


                <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
                    <div class="badge-flip-inner">
                        <div class="badge-flip-front">
                            <img
                                src="<?= base_url('/assets/logo/LOGO_js.svg') ?>"
                                alt=""
                                style="max-height: 50px"
                                class="img-fluid m-1" />
                        </div>
                        <div class="badge-flip-back">

                            <span class="skill-percent">JavaScript || 85%</span>
                        </div>
                    </div>
                </li>

                <li class=" badge-flip list-inline-item badge bg-info m-2 px-2">
                    <div class="badge-flip-inner">
                        <div class="badge-flip-front">
                            <img
                                src="<?= base_url('/assets/logo/LOGO_java.svg') ?>"
                                alt=""
                                style="max-height: 50px"
                                class="img-fluid m-1" />
                        </div>
                        <div class="badge-flip-back">

                            <span class="skill-percent">Java || 85%</span>
                        </div>
                    </div>
                </li>

                <li class="badge-flip list-inline-item badge bg-info m-2 px-2"">
                    <div class=" badge-flip-inner">
                    <div class="badge-flip-front">
                        <img
                            src="<?= base_url('/assets/logo/LOGO_csharp.svg') ?>"
                            alt=""
                            style="max-height: 50px"
                            class="img-fluid m-1" />
                    </div>
                    <div class="badge-flip-back">

                        <span class="skill-percent">C# || 85%</span>
                    </div>
        </div>
        </li>

        <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
            <div class="badge-flip-inner">
                <div class="badge-flip-front">
                    <img
                        src="<?= base_url('/assets/logo/LOGO_ci.svg') ?>"
                        alt=""
                        style="max-height: 50px"
                        class="img-fluid m-1" />
                </div>
                <div class="badge-flip-back">

                    <span class="skill-percent">CodeIgniter || 85%</span>
                </div>
            </div>
        </li>

        <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
            <div class="badge-flip-inner ">
                <div class="badge-flip-front">
                    <img
                        src="<?= base_url('/assets/logo/LOGO_bs.svg') ?>"
                        alt=""
                        style="max-height: 50px"
                        class="img-fluid m-1" />
                </div>
                <div class="badge-flip-back">

                    <span class="skill-percent">Bootstrap || 85%</span>
                </div>
            </div>
        </li>

        <li class=" badge-flip list-inline-item badge bg-info m-2 px-2" tab-index="0">
            <div class="badge-flip-inner">
                <div class="badge-flip-front">
                    <img
                        src="<?= base_url('/assets/logo/LOGO_sql.svg') ?>"
                        alt=""
                        style="max-height: 50px"
                        class="img-fluid m-1" />
                </div>
                <div class="badge-flip-back">
                    <span class="skill-percent">MySQL || 85%</span>
                </div>
            </div>
        </li>

        <li class="badge-flip list-inline-item badge bg-info m-2 px-2">
            <div class="badge-flip-inner">
                <div class="badge-flip-front">
                    <img
                        src="<?= base_url('/assets/logo/LOGO_mongo.svg') ?>"
                        alt=""
                        style="max-height: 50px"
                        class="img-fluid m-1" />
                </div>
                <div class="badge-flip-back">
                    <span class="skill-percent">MongoDB || 85%</span>
                </div>
            </div>
        </li>
        </ul>
        </div>
    </article>
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
    });
</script>


