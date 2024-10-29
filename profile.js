document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    
    const usernameDisplay = document.getElementById('usernameDisplay');
    const usernameInput = document.getElementById('usernameInput');
    
    const usernameText = document.getElementById('usernameText');
    const usernameField = document.getElementById('usernameField');
    
    // Show input field to edit username
    editBtn.addEventListener('click', () => {
        usernameDisplay.classList.add('hidden');
        usernameInput.classList.remove('hidden');
    });
    
    // Save the edited username
    saveBtn.addEventListener('click', () => {
        const newUsername = usernameField.value.trim();
        if (newUsername !== "") {
            usernameText.textContent = newUsername;
        }
        usernameDisplay.classList.remove('hidden');
        usernameInput.classList.add('hidden');
    });
    
    // Cancel editing and hide the input field
    cancelBtn.addEventListener('click', () => {
        usernameDisplay.classList.remove('hidden');
        usernameInput.classList.add('hidden');
        usernameField.value = usernameText.textContent;  // reset input value to the current username
    });
});