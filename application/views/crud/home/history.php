 <main class="container mb-5 p-2 my-3 rounded" id="content">

    <!-- Threads made by user -->
    <section class="container my-2" id="recent">
        <h1>Your Posts</h1>
        <article id="cards_recent">
            <?php foreach ($threads as $thread): ?>
                <a class="card mb-3 mx-5" style="min-height: 20vh;" href="<?= base_url($thread['slug']) ?>">

                    <div class="card-body mb-4">
                        <div class="row">
                            <div class="d-flex flex-wrap align-items-baseline">
                                <p class="text-muted mb-0">u/<?= $thread['username'] ?></p>
                                <span class="text-muted">&ensp;&ensp;&#128905; <?= time_elapsed($thread['created_at']) ?></span>
                                <?php if (isset($thread['active']) && (int) $thread['active'] === 0): ?>
                                    <span class="text-muted ms-2 small">· Closed thread</span>
                                <?php endif; ?>
                            </div>
                            <div class="">
                                <h5 class="card-title" id="card-title"><?= $thread['title'] ?></h5>
                            </div>
                        </div>
                        <div class="text-truncate">

                            <p class="card-text"><?= $thread['content'] ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </article>
    </section>
</main>