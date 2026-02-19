<?php
$thread_active = isset($thread->active) ? (int) $thread->active : 1;
$thread_user_id = isset($thread->user_id) ? $thread->user_id : null;
$is_thread_owner = $this->session->userdawta('is_logged_in') && $thread_user_id !== null && (int) $this->session->userdata('id') === (int) $thread_user_id;
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
    const BASE_URL = '<?= base_url() ?>';
    const THREAD_ID = '<?= $thread->id ?>';
    const THREAD_TITLE = <?= json_encode($thread->title) ?>;
    const THREAD_CONTENT = <?= json_encode($thread->content) ?>;

    function startThreadEdit() {
        const titleWrap = document.getElementById('thread-title-wrap');
        const contentWrap = document.getElementById('thread-content-wrap');
        if (!titleWrap || !contentWrap) return;
        const origTitle = titleWrap.innerHTML;
        const origContent = contentWrap.innerHTML;

        const form = document.createElement('form');
        form.method = 'post';
        form.action = BASE_URL + 'update_thread/' + THREAD_ID;
        form.className = 'd-flex flex-column';

        const titleDiv = document.createElement('div');
        titleDiv.className = 'form-floating my-2';
        const titleInput = document.createElement('input');
        titleInput.type = 'text';
        titleInput.className = 'form-control';
        titleInput.name = 'title';
        titleInput.id = 'edit_thread_title';
        titleInput.required = true;
        titleInput.value = THREAD_TITLE;
        const titleLabel = document.createElement('label');
        titleLabel.htmlFor = 'edit_thread_title';
        titleLabel.textContent = 'Title';
        titleDiv.appendChild(titleInput);
        titleDiv.appendChild(titleLabel);

        const contentDiv = document.createElement('div');
        contentDiv.className = 'thread-textarea form-floating my-2';
        const contentTa = document.createElement('textarea');
        contentTa.className = 'form-control';
        contentTa.name = 'content';
        contentTa.id = 'edit_thread_content';
        contentTa.rows = 8;
        contentTa.required = true;
        contentTa.value = THREAD_CONTENT;
        const contentLabel = document.createElement('label');
        contentLabel.htmlFor = 'edit_thread_content';
        contentLabel.textContent = 'Content';
        contentDiv.appendChild(contentTa);
        contentDiv.appendChild(contentLabel);

        const btnRow = document.createElement('div');
        btnRow.className = 'd-grid gap-2 d-md-block';
        const submitBtn = document.createElement('button');
        submitBtn.type = 'submit';
        submitBtn.className = 'btn btn-outline-primary float-end me-2';
        submitBtn.textContent = 'Save';
        const cancelBtn = document.createElement('button');
        cancelBtn.type = 'button';
        cancelBtn.className = 'btn btn-secondary float-end';
        cancelBtn.textContent = 'Cancel';
        btnRow.appendChild(submitBtn);
        btnRow.appendChild(cancelBtn);

        form.appendChild(titleDiv);
        form.appendChild(contentDiv);
        form.appendChild(btnRow);

        titleWrap.innerHTML = '';
        contentWrap.innerHTML = '';
        titleWrap.appendChild(form);

        cancelBtn.addEventListener('click', function() {
            titleWrap.innerHTML = origTitle;
            contentWrap.innerHTML = origContent;
        });
    }

    function startInlineEdit(container, type, id) {
        const contentP = container.querySelector('.content p');
        if (!contentP) return;
        // save original
        container.dataset.original = contentP.innerHTML;
        // convert <br> to newlines for textarea
        let text = container.dataset.original.replace(/<br\s*\/?>(\r\n|\n|\r)?/gi, '\n');

        const form = document.createElement('form');
        form.method = 'post';
        form.action = BASE_URL + (type === 'reply' ? 'edit_reply/' + id : 'edit_comment/' + id);
        form.className = 'd-flex flex-column';

        const hiddenThread = document.createElement('input');
        hiddenThread.type = 'hidden';
        hiddenThread.name = 'thread_id';
        hiddenThread.value = THREAD_ID;

        const textareaDiv = document.createElement('div');
        textareaDiv.className = 'thread-textarea form-floating my-2';

        const textarea = document.createElement('textarea');
        const taId = type + '_edit_' + id;
        textarea.id = taId;
        textarea.className = 'form-control';
        textarea.name = 'comment';
        textarea.rows = 5;
        textarea.required = true;
        textarea.placeholder = 'Enter comment here...';
        textarea.value = text;

        const label = document.createElement('label');
        label.htmlFor = taId;
        label.textContent = 'Edit';

        textareaDiv.appendChild(textarea);
        textareaDiv.appendChild(label);

        const btnRow = document.createElement('div');
        btnRow.className = 'd-grid gap-2 d-md-block';

        const confirm = document.createElement('button');
        confirm.type = 'submit';
        confirm.className = 'btn btn-outline-primary float-end me-2';
        confirm.textContent = 'Confirm';

        const cancel = document.createElement('button');
        cancel.type = 'button';
        cancel.className = 'btn btn-secondary float-end';
        cancel.textContent = 'Cancel';

        btnRow.appendChild(confirm);
        btnRow.appendChild(cancel);

        form.appendChild(hiddenThread);
        form.appendChild(textareaDiv);
        form.appendChild(btnRow);

        // replace content paragraph with form
        contentP.parentNode.replaceChild(form, contentP);

        cancel.addEventListener('click', function(e) {
            e.preventDefault();
            const p = document.createElement('p');
            p.className = contentP.className;
            p.innerHTML = container.dataset.original;
            form.parentNode.replaceChild(p, form);
        });
    }

    document.addEventListener('click', function(e) {
        const threadEditBtn = e.target.closest('.edit-thread-btn');
        const replyBtn = e.target.closest('.edit-reply-btn');
        const commentBtn = e.target.closest('.edit-comment-btn');
        const deleteLink = e.target.closest('.delete-confirm-swal');
        if (deleteLink) {
            e.preventDefault();
            const href = deleteLink.getAttribute('data-href');
            const title = deleteLink.getAttribute('data-title') || 'Are you sure?';
            const text = deleteLink.getAttribute('data-text') || '';
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed && href) {
                    window.location.href = href;
                }
            });
            return;
        }
        if (threadEditBtn) {
            startThreadEdit();
        }
        if (replyBtn) {
            const id = replyBtn.dataset.id;
            const container = replyBtn.closest('.reply-container');
            startInlineEdit(container, 'reply', id);
        }
        if (commentBtn) {
            const id = commentBtn.dataset.id;
            const container = commentBtn.closest('.reply-container');
            startInlineEdit(container, 'comment', id);
        }
    });
</script>