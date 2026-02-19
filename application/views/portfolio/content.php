<section id="projects" class="container-fluid py-5">
    <h2 class="display-4 text-center mb-4">Recent Projects</h2>
    <article class="d-flex flex-wrap justify-content-center">
        <?php
        foreach ($docs as $doc):
        ?>

            <div class="card mx-4 my-5 rounded-lg" style="max-width: 20rem; min-width: 20rem;">
                <div class="g-0">
                    <div class="project-thumb">
                        <img src="<?= base_url('assets/images/' . $doc['img']) ?>" alt="<?= $doc['title'] ?>" class="card-img img-fluid m-auto">
                    </div>
                    <div class="">
                        <div class="card-body">
                            <h5 class="card-title"><?= $doc['title'] ?></h5>
                            <p class="card-text"><?= $doc['summary'] ?></p>
                            <?php
                            $tag = explode(',', $doc['tags']);
                            foreach ($tag as $t) {
                                echo '<span class="badge bg-danger m-1 p-2"">' . trim($t) . '</span>';
                            }
                            ?>
                            <br>

                            <a href="<?= $doc['link'] ?>" class="card-link btn btn-warning my-4"><i class="bi bi-github"></i>View Project</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php

        endforeach;
        ?>
    </article>

</section>
