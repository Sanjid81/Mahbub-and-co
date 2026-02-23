/**
 * Apply form: client-side validation (required fields, email format)
 */
function initApplyFormValidation() {
  const section = document.querySelector('.apply-form-section');
  if (!section) return;

  const defaultRequiredNames = [
    'firstName', 'first-name', 'fullName', 'lastName', 'last-name', 'phoneNumber',
    'email', 'dateOfBirth', 'mobile', 'resumeRequired'
  ];

  const getRequiredFields = (form) => {
    const byType = form.querySelectorAll(
      'input[type="text*"], input[type="email*"], input[type="file*"]'
    );
    const byAttr = form.querySelectorAll(
      'input[required], input[data-required="true"], select[required], select[data-required="true"], textarea[required], textarea[data-required="true"], ' +
      '.wpcf7-form-control.wpcf7-validates-as-required'
    );
    const byName = form.querySelectorAll(
      defaultRequiredNames.map((n) => `input[name="${n}"], select[name="${n}"]`).join(', ')
    );
    const combined = new Set([...byType, ...byAttr, ...byName]);
    return [...combined];
  };

  const clearErrors = (form, sectionEl) => {
    if (!sectionEl) sectionEl = section;
    sectionEl.querySelectorAll('.apply-form-error').forEach((el) => el.remove());
    sectionEl.querySelectorAll('.form-group.has-error').forEach((el) => el.classList.remove('has-error'));
    if (!form) return;
    const output = form.querySelector('.wpcf7-response-output');
    if (output) {
      output.removeAttribute('role');
      output.textContent = '';
      output.classList.remove('apply-form-validation-error');
    }
  };

  const showFieldError = (field, message) => {
    const group = field.closest('.form-group');
    if (!group) return;
    group.classList.add('has-error');
    let err = group.querySelector('.apply-form-error');
    if (!err) {
      err = document.createElement('span');
      err.className = 'apply-form-error';
      err.setAttribute('role', 'alert');
      group.appendChild(err);
    }
    err.textContent = message;
  };

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  section.addEventListener('submit', (e) => {
    const form = e.target;
    if (!form || !form.matches('form.wpcf7-form')) return;

    clearErrors(form, section);

    const requiredFields = getRequiredFields(form);
    let firstInvalid = null;
    let invalidCount = 0;

    requiredFields.forEach((field) => {
      const isFile = field.type === 'file' || field.type === 'file*';
      const value = isFile ? (field.files && field.files.length) : (field.value && field.value.trim());
      const isEmpty = value === '' || value === undefined || value === null;

      if (isEmpty) {
        invalidCount++;
        if (!firstInvalid) firstInvalid = field;
        const label = field.closest('.form-group')?.querySelector('label');
        const labelText = label ? label.textContent.replace(/\s*\*\s*$/, '').trim() : field.name || 'This field';
        showFieldError(field, labelText + ' is required.');
      } else if ((field.type === 'email' || field.type === 'email*') && field.value.trim() && !emailRegex.test(field.value.trim())) {
        invalidCount++;
        if (!firstInvalid) firstInvalid = field;
        showFieldError(field, 'Please enter a valid email address.');
      }
    });

    if (invalidCount > 0) {
      e.preventDefault();
      e.stopImmediatePropagation();
      if (firstInvalid) {
        firstInvalid.focus();
      }
      const output = form.querySelector('.wpcf7-response-output');
      if (output) {
        output.classList.add('apply-form-validation-error');
        output.setAttribute('role', 'alert');
        output.textContent = 'Please fill in all required fields correctly.';
      }
      return false;
    }
  }, true);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApplyFormValidation);
} else {
  initApplyFormValidation();
}
