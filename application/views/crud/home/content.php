<main class="container mb-5 p-2 my-3 rounded" id="content">
    <article class="container m-3">
        <form action="create_thread" method="post" class="container w-100">
            <div class="form-floating my-3">
                <input
                    type="text"
                    class="form-control "
                    id="floatingInput"
                    name="title"
                    placeholder="name@example.com" />
                <label for="floatingInput">Title</label>
            </div>
            <div class="form-floating my-2">
                <textarea class="form-control" id="content" name="content" rows="5" required placeholder="Enter content here..."></textarea>
                <label for="content">What's on your mind?</label>
            </div>
            <button type="submit" class="btn btn-primary w-25">Create Thread</button>
        </form>
    </article>


    <!-- Recent threads -->
    <section class="container my-2" id="recent">
        <h1>Recent Threads</h1>
        <article id="cards_recent">
            <?php foreach ($threads as $thread): ?>
                <a class="card mb-3 mx-5" style="min-height: 15vh;" href="<?= base_url($thread['slug']) ?>">

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
                        <p class="card-text"><?= $thread['content'] ?></p>
                        <div id="counter">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text-fill" viewBox="0 0 16 16">
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-2.5a1 1 0 0 0-.8.4l-1.9 2.533a1 1 0 0 1-1.6 0L5.3 12.4a1 1 0 0 0-.8-.4H2a2 2 0 0 1-2-2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z" />
                                </svg> <?= $thread['total_comments_replies'] ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </article>
    </section>
</main>