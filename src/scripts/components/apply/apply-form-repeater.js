/**
 * Dynamic Repeater for Experience and Education Fields in Apply Form
 */
function initApplyFormRepeater() {
  function setupRepeater({ containerId, blockClass, addButtonId, removeButtonClass, hiddenFieldName, serializeFn }) {
    const container = document.getElementById(containerId);
    const addButton = document.getElementById(addButtonId);
    if (!container || !addButton) return;

    const form = container.closest('form');
    if (!form) return;

    let hiddenField = form.querySelector(`[name="${hiddenFieldName}"]`);
    if (!hiddenField) {
      hiddenField = document.createElement('textarea');
      hiddenField.name = hiddenFieldName;
      hiddenField.id = hiddenFieldName;
      hiddenField.style.display = 'none';
      form.appendChild(hiddenField);
    }

    let blockCounter = 1;

    const updateSummary = () => {
      const blocks = container.querySelectorAll(`.${blockClass}`);
      let summaryText = '';

      blocks.forEach((block, index) => {
        summaryText += serializeFn(block, index);
      });

      hiddenField.value = summaryText.trim();
    };

    // Listen to changes in inputs
    container.addEventListener('input', updateSummary);
    container.addEventListener('change', updateSummary);

    addButton.addEventListener('click', () => {
      blockCounter++;
      
      const firstBlock = container.querySelector(`.${blockClass}`);
      if (!firstBlock) return;

      const newBlock = firstBlock.cloneNode(true);

      // Clear all input values and adjust names/IDs to prevent conflicts
      const inputs = newBlock.querySelectorAll('input, select, textarea');
      inputs.forEach((input) => {
        input.value = '';
        
        // Clean up the name attribute
        const baseName = input.name.replace(/_\d+$/, '');
        input.name = `${baseName}_${blockCounter}`;
        
        // Update ID
        if (input.id) {
          const baseId = input.id.replace(/-\d+$/, '');
          input.id = `${baseId}-${blockCounter}`;
        }
      });

      // Update label "for" attributes
      const labels = newBlock.querySelectorAll('label');
      labels.forEach((label) => {
        const htmlFor = label.getAttribute('for');
        if (htmlFor) {
          const baseFor = htmlFor.replace(/-\d+$/, '');
          label.setAttribute('for', `${baseFor}-${blockCounter}`);
        }
      });
      
      // Customize labels for cloned experience blocks
      if (containerId === 'experience-repeater-container') {
        const companyLabel = newBlock.querySelector('label[for^="currentCompany"]');
        if (companyLabel) {
          companyLabel.textContent = 'Previous Company (Required)';
        }
        const ctcLabel = newBlock.querySelector('label[for^="currentCTC"]');
        if (ctcLabel) {
          ctcLabel.textContent = 'Previous CTC (Monthly/Yearly)';
        }
      }

      // Add Remove button
      const removeBtnContainer = document.createElement('div');
      removeBtnContainer.className = 'remove-btn-wrapper';
      removeBtnContainer.innerHTML = `
        <button type="button" class="${removeButtonClass}">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
          Remove
        </button>
      `;
      
      newBlock.appendChild(removeBtnContainer);

      // Remove event
      removeBtnContainer.querySelector(`.${removeButtonClass}`).addEventListener('click', () => {
        newBlock.remove();
        updateSummary();
      });

      container.appendChild(newBlock);
      
      const firstInput = newBlock.querySelector('input, select');
      if (firstInput) firstInput.focus();

      updateSummary();
    });

    // Handle submit sync
    form.addEventListener('submit', updateSummary);
  }

  // Initialize Experience Repeater
  setupRepeater({
    containerId: 'experience-repeater-container',
    blockClass: 'experience-block',
    addButtonId: 'add-experience-btn',
    removeButtonClass: 'btn-remove-experience',
    hiddenFieldName: 'all_experiences',
    serializeFn: (block, index) => {
      const company = block.querySelector('[name^="currentCompany"]')?.value || '';
      const jobTitle = block.querySelector('[name^="jobTitle"]')?.value || '';
      const experience = block.querySelector('[name^="experience"]')?.value || '';
      const ctc = block.querySelector('[name^="currentCTC"]')?.value || '';

      if (company || jobTitle || experience || ctc) {
        return `Experience #${index + 1}:\nCompany: ${company}\nJob Title: ${jobTitle}\nExperience: ${experience}\nCTC: ${ctc}\n\n`;
      }
      return '';
    }
  });

  // Initialize Education Repeater
  setupRepeater({
    containerId: 'education-repeater-container',
    blockClass: 'education-block',
    addButtonId: 'add-education-btn',
    removeButtonClass: 'btn-remove-education',
    hiddenFieldName: 'all_education',
    serializeFn: (block, index) => {
      const institute = block.querySelector('[name^="institute"]')?.value || '';
      const degree = block.querySelector('[name^="degree"]')?.value || '';
      const industry = block.querySelector('[name^="industry"]')?.value || '';
      const graduation = block.querySelector('[name^="graduation"]')?.value || '';
      const result = block.querySelector('[name^="result"]')?.value || '';

      if (institute || degree || industry || graduation || result) {
        return `Education #${index + 1}:\nInstitute: ${institute}\nDegree: ${degree}\nSector/Department: ${industry}\nYear of Graduation: ${graduation}\nResult: ${result}\n\n`;
      }
      return '';
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApplyFormRepeater);
} else {
  initApplyFormRepeater();
}
