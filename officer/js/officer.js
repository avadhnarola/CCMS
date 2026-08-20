document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      navLinks.forEach((item) => item.classList.remove('active'));
      link.classList.add('active');
    });
  });

  const priorityItems = document.querySelectorAll('.priority-item');
  const processNextButton = document.querySelector('.process-next');

  if (processNextButton) {
    processNextButton.addEventListener('click', () => {
      priorityItems.forEach((item) => item.classList.remove('active'));

      const highestPriorityItem = [...priorityItems].find((item) => item.dataset.priority === 'CRITICAL') || priorityItems[0];
      highestPriorityItem.classList.add('active');
    });
  }

  const modal = document.getElementById('status-modal');
  const modalTrigger = document.querySelector('[data-modal-trigger="status-modal"]');
  const closeButtons = document.querySelectorAll('.close-modal, .close-modal-btn');
  const confirmStatus = document.querySelector('.confirm-status');

  const openModal = () => {
    if (modal) {
      modal.classList.add('visible');
      modal.setAttribute('aria-hidden', 'false');
    }
  };

  const closeModal = () => {
    if (modal) {
      modal.classList.remove('visible');
      modal.setAttribute('aria-hidden', 'true');
    }
  };

  if (modalTrigger) {
    modalTrigger.addEventListener('click', openModal);
  }

  closeButtons.forEach((button) => button.addEventListener('click', closeModal));

  if (modal) {
    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        closeModal();
      }
    });
  }

  if (confirmStatus) {
    confirmStatus.addEventListener('click', () => {
      const statusTag = document.querySelector('.case-header-actions .status-tag');
      if (statusTag) {
        statusTag.textContent = 'Current Status: Evidence Collection';
      }
      closeModal();
    });
  }
});
