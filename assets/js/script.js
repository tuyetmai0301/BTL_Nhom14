/* assets/js/script.js
   Lightweight UI helpers:
   - toggle sidebar (if you later make it collapsible)
   - form validation (simple)
   - image preview for upload
   - enroll via fetch (AJAX friendly)
*/

document.addEventListener('DOMContentLoaded', function () {
  // sidebar toggle (if you add a button)
  const sidebarToggle = document.querySelector('[data-toggle-sidebar]');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
      document.querySelector('.sidebar').classList.toggle('collapsed');
    });
  }

  // image preview for inputs with data-preview-target attribute
  document.querySelectorAll('input[type=file][data-preview-target]').forEach(input => {
    input.addEventListener('change', e => {
      const file = e.target.files[0];
      const targetSelector = input.getAttribute('data-preview-target');
      const target = document.querySelector(targetSelector);
      if (!file || !target) return;
      const reader = new FileReader();
      reader.onload = function(evt){
        target.src = evt.target.result;
      };
      reader.readAsDataURL(file);
    });
  });

  // simple form validation (data-required)
  document.querySelectorAll('form[data-validate]').forEach(form => {
    form.addEventListener('submit', e => {
      const invalid = [];
      form.querySelectorAll('[data-required]').forEach(inp => {
        if (!inp.value || inp.value.trim() === '') {
          invalid.push(inp);
        }
      });
      if (invalid.length) {
        e.preventDefault();
        invalid[0].focus();
        alert('Vui lòng điền đầy đủ các trường bắt buộc');
      }
    });
  });

  // enroll action via AJAX (optional)
  document.querySelectorAll('[data-action="enroll"]').forEach(btn => {
    btn.addEventListener('click', async e => {
      e.preventDefault();
      const courseId = btn.dataset.courseId;
      if (!courseId) return;
      btn.disabled = true;
      btn.textContent = 'Đang xử lý...';
      try {
        const form = new FormData();
        form.append('controller','enrollment');
        form.append('action','enrollAjax');
        form.append('course_id', courseId);
        const res = await fetch('index.php', { method:'POST', body: form });
        const json = await res.json();
        if (json.success) {
          btn.textContent = 'Đã đăng ký';
          btn.classList.add('disabled');
        } else {
          alert(json.message || 'Đăng ký thất bại');
          btn.disabled = false;
          btn.textContent = 'Đăng ký';
        }
      } catch(err){
        alert('Lỗi mạng hoặc server');
        btn.disabled = false;
        btn.textContent = 'Đăng ký';
      }
    });
  });
});
