<?php
$thread_active = isset($thread->active) ? (int) $thread->active : 1;
$thread_user_id = isset($thread->user_id) ? $thread->user_id : null;
$is_thread_owner = $this->session->userdata('is_logged_in') && $thread_user_id !== null && (int) $this->session->userdata('id') === (int) $thread_user_id;
$can_post = $thread_active === 1 && $this->session->userdata('is_logged_in');
?>
<main class="container py-5 rounded-3 my-2" id="main-content">
    <?php if ($thread_active === 0): ?>
        <div class="alert alert-secondary mx-2" role="alert">This thread is closed. No new comments or replies.</div>
    <?php endif; ?>
    <section class="container" id="thread-content">
        <div class="d-flex justify-content-between align-items-baseline">
            <div class="user d-flex flex-row align-items-baseline">
                <p class="ms-1 mb-0">u/<?= $thread->username ?></p>
                <small class="text-secondary ms-2"><?= time_elapsed($thread->created_at) ?><?php if (!empty($thread->updated_at) && strtotime($thread->updated_at) > strtotime($thread->created_at)): ?> <span class="text-muted">edited</span><?php endif; ?></small>
            </div>
            <?php if ($is_thread_owner): ?>
                <div class="dropdown">
                    <button class="btn btn-sm btn-link text-white" type="button" id="dropdownThread" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownThread">
                        <li><button type="button" class="dropdown-item edit-thread-btn" data-id="<?= $thread->id ?>">Edit</button></li>
                        <li><a class="dropdown-item text-danger delete-confirm-swal" href="<?= base_url('close_thread/' . $thread->id) ?>" data-href="<?= base_url('close_thread/' . $thread->id) ?>" data-title="Close thread?" data-text="No new comments or replies will be allowed.">Delete</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="title border-bottom" id="thread-title-wrap">
            <h1><?= htmlspecialchars($thread->title) ?></h1>
        </div>
        <div class="content mt-2" id="thread-content-wrap">
            <p><?= nl2br(htmlspecialchars($thread->content)) ?></p>
        </div>
    </section>
    <section class="container my-5 mx-auto " id="thread-comments">
        <?php if ($can_post): ?>
            <article class="comment my-3" id="input_comment">
                <form action="<?= base_url('add_comment') ?>" method="post" class="d-flex flex-column">

                    <input type="hidden" name="thread_id" value="<?= $thread->id ?>">
                    <div class="thread-textarea form-floating my-2">
                        <textarea class="form-control" id="comment" name="comment" rows="5" required placeholder="Enter comment here..."></textarea>
                        <label for="comment">Comment</label>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-outline-primary float-end">Post Comment</button>
                    </div>
                </form>
            </article>
        <?php endif; ?>
        <article class="comment">
            <?php
            if (empty($comments)) {
                echo '<p class="text-center">No comments yet. Be the first to comment!</p>';
            } else {
                // Helper function to recursively display replies with depth limit
                function display_replies($replies, $depth = 0, $max_depth = 3, $current_user_id = null, $current_thread_id = null)
                {
                    if (empty($replies) || $depth > $max_depth) {
                        return;
                    }
                    foreach ($replies as $reply): ?>
                        <div class="reply-container reply-level-<?= $depth ?>">
                            <div class="d-flex justify-content-between">
                                <div class="user d-flex flex-row align-items-baseline">
                                    <p class=""><strong>u/<?= $reply['username'] ?></strong></p>
                                    <small class="text-secondary ms-2"><?= time_elapsed($reply['created_at']) ?><?php if (!empty($reply['updated_at']) && strtotime($reply['updated_at']) > strtotime($reply['created_at'])): ?> <small class="text-white">(edited)</small><?php endif; ?></small>
                                </div>
                                <div class="d-flex flex-row">
                                    <?php if ($current_user_id === $reply['user_id']): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link text-white" type="button" id="dropdownReply<?= $reply['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownReply<?= $reply['id'] ?>">
                                                <li><button type="button" class="dropdown-item edit-reply-btn" data-id="<?= $reply['id'] ?>" data-thread="<?= $current_thread_id ?>">Edit</button></li>
                                                <li><a class="dropdown-item text-danger delete-confirm-swal" href="<?= base_url('delete_reply/' . $reply['id'] . '/' . $current_thread_id) ?>" data-href="<?= base_url('delete_reply/' . $reply['id'] . '/' . $current_thread_id) ?>" data-title="Delete reply?" data-text="This reply will be removed.">Delete</a></li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="content">
                                <p class="mt-0 mb-2"><?= nl2br($reply['content']) ?></p>
                            </div>
                            <?php
                            // Recursively display nested replies if they exist
                            if (!empty($reply['replies']) && $depth < $max_depth) {
                                display_replies($reply['replies'], $depth + 1, $max_depth, $current_user_id, $current_thread_id);
                            } elseif (!empty($reply['replies']) && $depth >= $max_depth) {
                                echo '<p class="collapsed-replies">Replies hidden (max depth reached)</p>';
                            }
                            ?>

                        </div>

                    <?php endforeach;
                }

                foreach ($comments as $comment): ?>
                    <article class="mt-5 reply-container reply-level-0">
                        <div class="d-flex justify-content-between">
                            <div class="user d-flex flex-row align-items-baseline">
                                <p class="mb-0"><strong>u/<?= $comment['username'] ?></strong></p>
                                <small class="text-secondary ms-2"><?= time_elapsed($comment['comment_time']) ?><?php if (!empty($comment['updated_at']) && strtotime($comment['updated_at']) > strtotime($comment['comment_time'])): ?> <span class="text-secondary">(edited)</span><?php endif; ?></small>
                            </div>
                            <div class="d-flex flex-row">
                                <?php if ($this->session->userdata('id') === $comment['user_id']): ?>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-white" type="button" id="dropdownComment<?= $comment['id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownComment<?= $comment['id'] ?>">
                                            <li><button type="button" class="dropdown-item edit-comment-btn" data-id="<?= $comment['id'] ?>" data-thread="<?= $thread->id ?>">Edit</button></li>
                                            <li><a class="dropdown-item text-danger delete-confirm-swal" href="<?= base_url('delete_comment/' . $comment['id'] . '/' . $thread->id) ?>" data-href="<?= base_url('delete_comment/' . $comment['id'] . '/' . $thread->id) ?>" data-title="Delete comment?" data-text="This comment will be removed.">Delete</a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="content">
                            <p class="mt-1 mb-2"><?= nl2br($comment['content']) ?></p>
                        </div>
                        <?php if ($can_post): ?>
                            <article class="comment w-75" id="input_reply_to_comment">
                                <form action="<?= base_url('add_reply') ?>" method="post" class="d-flex flex-column">
                                    <input type="hidden" name="thread_id" value="<?= $thread->id ?>">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <div class="thread-textarea form-floating my-2">
                                        <textarea class="form-control" id="reply_to_comment" name="comment" rows="5" required placeholder="Enter comment here..."></textarea>
                                        <label for="reply_to_comment">Post reply</label>
                                    </div>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button type="submit" class="btn btn-outline-primary float-end">Reply</button>
                                    </div>
                                </form>
                            </article>
                        <?php endif; ?>


                    </article>
                    <article>
                        <?php if (!empty($comment['replies'])): ?>
                            <?php display_replies($comment['replies'], 1, 3, $this->session->userdata('id'), $thread->id); ?>
                        <?php endif; ?>
                    </article>
            <?php endforeach;
            }
            ?>

        </article>
    </section>
</main>

<script>
    window.THREAD_CONFIG = {
        baseUrl: <?= json_encode(base_url()) ?>,
        threadId: <?= json_encode($thread->id) ?>,
        title: <?= json_encode($thread->title) ?>,
        content: <?= json_encode($thread->content) ?>
    };
</script>
<script src="<?= base_url('js/crud/thread.js') ?>"></script>