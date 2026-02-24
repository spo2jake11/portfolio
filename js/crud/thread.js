(function() {
	'use strict';

	var config = window.THREAD_CONFIG;
	if (!config) return;

	var BASE_URL = config.baseUrl;
	var THREAD_ID = config.threadId;
	var THREAD_TITLE = config.title;
	var THREAD_CONTENT = config.content;

	function startThreadEdit() {
		var titleWrap = document.getElementById('thread-title-wrap');
		var contentWrap = document.getElementById('thread-content-wrap');
		if (!titleWrap || !contentWrap) return;
		var origTitle = titleWrap.innerHTML;
		var origContent = contentWrap.innerHTML;

		var form = document.createElement('form');
		form.method = 'post';
		form.action = BASE_URL + 'update_thread/' + THREAD_ID;
		form.className = 'd-flex flex-column';

		var titleDiv = document.createElement('div');
		titleDiv.className = 'form-floating my-2';
		var titleInput = document.createElement('input');
		titleInput.type = 'text';
		titleInput.className = 'form-control';
		titleInput.name = 'title';
		titleInput.id = 'edit_thread_title';
		titleInput.required = true;
		titleInput.value = THREAD_TITLE;
		var titleLabel = document.createElement('label');
		titleLabel.htmlFor = 'edit_thread_title';
		titleLabel.textContent = 'Title';
		titleDiv.appendChild(titleInput);
		titleDiv.appendChild(titleLabel);

		var contentDiv = document.createElement('div');
		contentDiv.className = 'thread-textarea form-floating my-2';
		var contentTa = document.createElement('textarea');
		contentTa.className = 'form-control';
		contentTa.name = 'content';
		contentTa.id = 'edit_thread_content';
		contentTa.rows = 8;
		contentTa.required = true;
		contentTa.value = THREAD_CONTENT;
		var contentLabel = document.createElement('label');
		contentLabel.htmlFor = 'edit_thread_content';
		contentLabel.textContent = 'Content';
		contentDiv.appendChild(contentTa);
		contentDiv.appendChild(contentLabel);

		var btnRow = document.createElement('div');
		btnRow.className = 'd-grid gap-2 d-md-block';
		var submitBtn = document.createElement('button');
		submitBtn.type = 'submit';
		submitBtn.className = 'btn btn-outline-primary float-end me-2';
		submitBtn.textContent = 'Save';
		var cancelBtn = document.createElement('button');
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
		var contentP = container.querySelector('.content p');
		if (!contentP) return;
		container.dataset.original = contentP.innerHTML;
		var text = container.dataset.original.replace(/<br\s*\/?>(\r\n|\n|\r)?/gi, '\n');

		var form = document.createElement('form');
		form.method = 'post';
		form.action = BASE_URL + (type === 'reply' ? 'edit_reply/' + id : 'edit_comment/' + id);
		form.className = 'd-flex flex-column';

		var hiddenThread = document.createElement('input');
		hiddenThread.type = 'hidden';
		hiddenThread.name = 'thread_id';
		hiddenThread.value = THREAD_ID;

		var textareaDiv = document.createElement('div');
		textareaDiv.className = 'thread-textarea form-floating my-2';

		var textarea = document.createElement('textarea');
		var taId = type + '_edit_' + id;
		textarea.id = taId;
		textarea.className = 'form-control';
		textarea.name = 'comment';
		textarea.rows = 5;
		textarea.required = true;
		textarea.placeholder = 'Enter comment here...';
		textarea.value = text;

		var label = document.createElement('label');
		label.htmlFor = taId;
		label.textContent = 'Edit';

		textareaDiv.appendChild(textarea);
		textareaDiv.appendChild(label);

		var btnRow = document.createElement('div');
		btnRow.className = 'd-grid gap-2 d-md-block';

		var confirm = document.createElement('button');
		confirm.type = 'submit';
		confirm.className = 'btn btn-outline-primary float-end me-2';
		confirm.textContent = 'Confirm';

		var cancel = document.createElement('button');
		cancel.type = 'button';
		cancel.className = 'btn btn-secondary float-end';
		cancel.textContent = 'Cancel';

		btnRow.appendChild(confirm);
		btnRow.appendChild(cancel);

		form.appendChild(hiddenThread);
		form.appendChild(textareaDiv);
		form.appendChild(btnRow);

		contentP.parentNode.replaceChild(form, contentP);

		cancel.addEventListener('click', function(e) {
			e.preventDefault();
			var p = document.createElement('p');
			p.className = contentP.className;
			p.innerHTML = container.dataset.original;
			form.parentNode.replaceChild(p, form);
		});
	}

	document.addEventListener('click', function(e) {
		var threadEditBtn = e.target.closest('.edit-thread-btn');
		var replyBtn = e.target.closest('.edit-reply-btn');
		var commentBtn = e.target.closest('.edit-comment-btn');
		var deleteLink = e.target.closest('.delete-confirm-swal');

		if (deleteLink) {
			e.preventDefault();
			var href = deleteLink.getAttribute('data-href');
			var title = deleteLink.getAttribute('data-title') || 'Are you sure?';
			var text = deleteLink.getAttribute('data-text') || '';
			if (typeof Swal !== 'undefined') {
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
			}
			return;
		}
		if (threadEditBtn) {
			startThreadEdit();
		}
		if (replyBtn) {
			var id = replyBtn.dataset.id;
			var container = replyBtn.closest('.reply-container');
			if (container) startInlineEdit(container, 'reply', id);
		}
		if (commentBtn) {
			var id = commentBtn.dataset.id;
			var container = commentBtn.closest('.reply-container');
			if (container) startInlineEdit(container, 'comment', id);
		}
	});
})();
