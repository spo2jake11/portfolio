<section id="projects" class="container-fluid py-5">
    <h2 class="display-4 text-center mb-4">Recent Projects</h2>
    <article class="container">
        <div class="row g-4 justify-content-center">
            <?php foreach ($docs as $doc): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 rounded shadow">
                        <div class="project-thumb">
                            <img src="<?= base_url('assets/images/' . $doc['img']) ?>" alt="<?= htmlspecialchars($doc['title']) ?>" class="card-img-top img-fluid">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($doc['title']) ?></h5>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($doc['summary']) ?></p>
                            <div class="mb-3">
                                <?php
                                $tags = explode(',', $doc['tags']);
                                foreach ($tags as $tag) {
                                    $tag = trim($tag);
                                    if ($tag) {
                                        echo '<span class="badge bg-danger m-1 p-2">' . htmlspecialchars($tag) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            <a href="<?= htmlspecialchars($doc['link']) ?>" target="_blank" rel="noopener noreferrer" class="card-link btn btn-warning mt-auto">
                                <i class="bi bi-github"></i> View Project
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>
