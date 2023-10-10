function addRow() {
    const newInput = document.createElement('input');
    newInput.className = 'input-pad';
    newInput.type = 'url';
    newInput.name = 'url[]';
    newInput.placeholder = 'Please enter a file URL';

    const wrapper = document.getElementById('div-urls');
    wrapper.appendChild(newInput);
}
