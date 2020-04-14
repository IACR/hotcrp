/* 
 *  A checkbox in HotCRP has a label that is also clickable. We want to make
 *  the checkbox unclickable, so we also have to remove the js-click-child
 *  class from the label of the checkbox.
 */
function removeClickEventOnCheckbox(id) {
  let cb = document.getElementById(id);
  if (!cb) {
    console.log('missing checkbox for ' + id);
    return;
  }
  // This will make the label unclickable.
  cb.parentNode.parentNode.parentNode.classList.remove('js-click-child');
  // This makes the checkbox unclickable. We can't make it disabled
  // because then it isn't submitted.
  cb.addEventListener('click', function(event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    return true;
  });
}

/*
 *  This is used on the paper submission form.
 */
function iacrSubmitAndUploadCheckboxes() {
  removeClickEventOnCheckbox('iacr-copyright-agreement');
  removeClickEventOnCheckbox('upload-final-paper');
  removeClickEventOnCheckbox('upload-slides');
  removeClickEventOnCheckbox('upload-video');
}

