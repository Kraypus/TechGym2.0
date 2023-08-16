function adjustImagePosition() {
    const rightColumn = document.querySelector('.w3-twothird');
    const fixedImage = document.querySelector('.image-container img');
    const rightColumnHeight = rightColumn.offsetHeight;
  
    fixedImage.style.position = 'absolute';
    fixedImage.style.top = `${rightColumnHeight}px`;
    fixedImage.style.left = '0';
  }
  
  // Call adjustImagePosition initially
  adjustImagePosition();
  
  // Create a MutationObserver instance
  const observer = new MutationObserver(() => {
    adjustImagePosition();
  });
  
  // Observe changes to the form-container elements
  const formContainers = document.querySelectorAll('.form-container');
  formContainers.forEach((container) => {
    observer.observe(container, { attributes: true, childList: true, subtree: true });
  });