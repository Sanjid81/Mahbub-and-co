/**
 * Apply form: show selected file name in file input placeholder
 */
function initApplyFormFileName() {
  const section = document.querySelector('.apply-form-section');
  if (!section) return;

  section.addEventListener('change', (e) => {
    const input = e.target;
    if (input.type !== 'file' || !input.matches('input[type="file"]')) return;

    const placeholder = input.closest('.file-group')?.querySelector('.file-placeholder');
    if (!placeholder) return;

    const file = input.files?.[0];
    placeholder.textContent = file ? file.name : 'Choose file';
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApplyFormFileName);
} else {
  initApplyFormFileName();
}
