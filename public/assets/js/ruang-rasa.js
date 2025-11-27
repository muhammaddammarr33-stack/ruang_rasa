// public/assets/js/ruang-rasa.js
document.addEventListener('DOMContentLoaded', function () {
  // Optional: smooth focus on first input
  const firstInput = document.querySelector('.form-control');
  if (firstInput) firstInput.focus();

  // Optional: prevent double-submit
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function () {
      const submitBtn = form.querySelector('.btn-primary');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';
      }
    });
  });

  // Optional: add subtle hover effect to links
  const links = document.querySelectorAll('.link');
  links.forEach(link => {
    link.addEventListener('mouseenter', () => link.style.opacity = '0.9');
    link.addEventListener('mouseleave', () => link.style.opacity = '1');
  });
});